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
}