<?php

namespace App\Filament\Pages;

use App\Models\CashFlow;
use App\Models\Attendance;
use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Carbon;
use App\Exports\LaporanKeuanganExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanKeuangan extends Page implements HasForms
{
    use InteractsWithForms;

    // Ikon dan judul halaman di sidebar
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Laporan Keuangan';
    protected static ?string $title = 'Laporan Keuangan';

    // Template halaman
    protected string $view = 'filament.pages.laporan-keuangan';

    // Filter yang dipilih user
    public string $filter = 'daily';
    public ?string $selectedDate = null;
    public ?string $selectedMonth = null;
    public ?string $selectedYear = null;

    // Filter tambahan untuk tabel detail transaksi
    public ?string $selectedType = null;     // null = semua, 'income', 'expense'
    public ?string $selectedCategory = null; // null = semua, atau salah satu kategori

    public function mount(): void
    {
        // Set default nilai filter
        $this->selectedDate = today()->format('Y-m-d');
        $this->selectedMonth = today()->format('Y-m');
        $this->selectedYear = today()->format('Y');
    }

    // Livewire otomatis panggil method ini setiap kali $selectedType berubah
    public function updatedSelectedType(): void
    {
        $this->selectedCategory = null;
    }

    // Hitung total pemasukan
    public function getTotalIncome(): float
    {
        return CashFlow::where('type', 'income')
            ->when($this->filter === 'daily', fn($q) => $q->whereDate('date', $this->selectedDate))
            ->when($this->filter === 'monthly', fn($q) => $q->whereYear('date', explode('-', $this->selectedMonth)[0])
                ->whereMonth('date', explode('-', $this->selectedMonth)[1]))
            ->when($this->filter === 'yearly', fn($q) => $q->whereYear('date', $this->selectedYear))
            ->sum('amount');
    }

    // Hitung total pengeluaran
    public function getTotalExpense(): float
    {
        return CashFlow::where('type', 'expense')
            ->when($this->filter === 'daily', fn($q) => $q->whereDate('date', $this->selectedDate))
            ->when($this->filter === 'monthly', fn($q) => $q->whereYear('date', explode('-', $this->selectedMonth)[0])
                ->whereMonth('date', explode('-', $this->selectedMonth)[1]))
            ->when($this->filter === 'yearly', fn($q) => $q->whereYear('date', $this->selectedYear))
            ->sum('amount');
    }

    // Hitung total gaji karyawan
    public function getTotalSalary(): float
    {
        return CashFlow::where('category', 'gaji')
            ->when($this->filter === 'daily', fn($q) => $q->whereDate('date', $this->selectedDate))
            ->when($this->filter === 'monthly', fn($q) => $q->whereYear('date', explode('-', $this->selectedMonth)[0])
                ->whereMonth('date', explode('-', $this->selectedMonth)[1]))
            ->when($this->filter === 'yearly', fn($q) => $q->whereYear('date', $this->selectedYear))
            ->sum('amount');
    }

    // Hitung laba bersih
    public function getNetProfit(): float
    {
        return $this->getTotalIncome() - $this->getTotalExpense();
    }

    // Ambil detail transaksi kas
    public function getTransactions()
    {
        return CashFlow::when($this->filter === 'daily', fn($q) => $q->whereDate('date', $this->selectedDate))
            ->when($this->filter === 'monthly', fn($q) => $q->whereYear('date', explode('-', $this->selectedMonth)[0])
                ->whereMonth('date', explode('-', $this->selectedMonth)[1]))
            ->when($this->filter === 'yearly', fn($q) => $q->whereYear('date', $this->selectedYear))
            ->when($this->selectedType, fn($q) => $q->where('type', $this->selectedType))
            ->when($this->selectedCategory, fn($q) => $q->where('category', $this->selectedCategory))
            ->orderBy('date', 'desc')
            ->get();
    }

    // Label periode untuk ditampilkan di PDF
    protected function getPeriodeLabel(): string
    {
        return match ($this->filter) {
            'daily' => 'Harian — ' . \Carbon\Carbon::parse($this->selectedDate)->translatedFormat('d F Y'),
            'monthly' => 'Bulanan — ' . \Carbon\Carbon::parse($this->selectedMonth . '-01')->translatedFormat('F Y'),
            'yearly' => 'Tahunan — ' . $this->selectedYear,
            default => '',
        };
    }

    // Label filter jenis/kategori aktif untuk ditampilkan di PDF
    protected function getFilterLabel(): string
    {
        $parts = [];
        if ($this->selectedType) {
            $parts[] = 'Jenis: ' . ($this->selectedType === 'income' ? 'Pemasukan' : 'Pengeluaran');
        }
        if ($this->selectedCategory) {
            $parts[] = 'Kategori: ' . ucfirst(str_replace('_', ' ', $this->selectedCategory));
        }
        return implode(', ', $parts);
    }

    // Export ke PDF (mengikuti filter aktif)
    public function exportPdf()
    {
        $pdf = Pdf::loadView('pdf.laporan-keuangan', [
            'transactions' => $this->getTransactions(),
            'totalIncome' => $this->getTotalIncome(),
            'totalExpense' => $this->getTotalExpense(),
            'totalSalary' => $this->getTotalSalary(),
            'netProfit' => $this->getNetProfit(),
            'periodeLabel' => $this->getPeriodeLabel(),
            'filterLabel' => $this->getFilterLabel(),
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'laporan-keuangan-' . now()->format('Ymd-His') . '.pdf'
        );
    }

    // Export ke Excel (mengikuti filter aktif)
    public function exportExcel()
    {
        return Excel::download(
            new LaporanKeuanganExport($this->getTransactions()),
            'laporan-keuangan-' . now()->format('Ymd-His') . '.xlsx'
        );
    }
}