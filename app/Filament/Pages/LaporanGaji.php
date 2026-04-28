<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\CashFlow;
use Filament\Pages\Page;

class LaporanGaji extends Page
{
    // Ikon dan judul halaman di sidebar
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Laporan Gaji';
    protected static ?string $title = 'Laporan Gaji Karyawan';

    // Template halaman
    protected string $view = 'filament.pages.laporan-gaji';

    // Filter bulan dan tahun
    public string $selectedMonth;
    public string $selectedYear;

    // Sistem kerja (5 atau 6 hari per minggu)
    public string $workDays = '25'; // 25 = 6 hari/minggu, 21 = 5 hari/minggu

    public function mount(): void
    {
        // Default bulan dan tahun ini
        $this->selectedMonth = now()->format('m');
        $this->selectedYear = now()->format('Y');
    }

    // Ambil data gaji semua karyawan aktif
    public function getSalaryData(): array
    {
        $employees = Employee::where('status', 'active')->get();
        $result = [];

        foreach ($employees as $employee) {
            // Hitung hari hadir (hadir = dibayar)
            $hariHadir = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', $this->selectedMonth)
                ->whereYear('date', $this->selectedYear)
                ->where('status', 'hadir')
                ->count();

            // Hitung hari izin (izin = dibayar, sesuai PP 78/2015)
            $hariIzin = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', $this->selectedMonth)
                ->whereYear('date', $this->selectedYear)
                ->where('status', 'izin')
                ->count();

            // Hitung hari sakit (sakit = dibayar, sesuai PP 78/2015)
            $hariSakit = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', $this->selectedMonth)
                ->whereYear('date', $this->selectedYear)
                ->where('status', 'sakit')
                ->count();

            // Hitung hari alpha (alpha = tidak dibayar)
            $hariAlpha = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', $this->selectedMonth)
                ->whereYear('date', $this->selectedYear)
                ->where('status', 'alpha')
                ->count();

            // Hari yang dibayar = hadir + izin + sakit
            $hariBayar = $hariHadir + $hariIzin + $hariSakit;

            // Hitung gaji per hari sesuai PP No. 36 Tahun 2021
            $gajiPerHari = $employee->salary / $this->workDays;

            // Hitung total gaji bulan ini
            $totalGaji = $gajiPerHari * $hariBayar;

            // Hitung potongan dari hari alpha
            $potongan = $gajiPerHari * $hariAlpha;

            $result[] = [
                'nama' => $employee->name,
                'jabatan' => $employee->position,
                'gaji_pokok' => $employee->salary,
                'hari_hadir' => $hariHadir,
                'hari_izin' => $hariIzin,
                'hari_sakit' => $hariSakit,
                'hari_alpha' => $hariAlpha,
                'hari_bayar' => $hariBayar,
                'gaji_per_hari' => $gajiPerHari,
                'potongan' => $potongan,
                'total_gaji' => $totalGaji,
                'employee_id' => $employee->id,
            ];
        }

        return $result;
    }

    // Hitung total gaji semua karyawan
    public function getTotalGaji(): float
    {
        return array_sum(array_column($this->getSalaryData(), 'total_gaji'));
    }

    // Simpan gaji ke cash flow
    public function bayarGaji(): void
    {
        $salaryData = $this->getSalaryData();

        foreach ($salaryData as $data) {
            // Cek apakah gaji bulan ini sudah dibayar
            $sudahBayar = CashFlow::where('category', 'gaji')
                ->where('description', 'like', '%' . $data['nama'] . '%')
                ->whereMonth('date', $this->selectedMonth)
                ->whereYear('date', $this->selectedYear)
                ->exists();

            if (!$sudahBayar && $data['total_gaji'] > 0) {
                CashFlow::create([
                    'type' => 'expense',
                    'category' => 'gaji',
                    'amount' => $data['total_gaji'],
                    'description' => 'Gaji ' . $data['nama'] . ' bulan ' .
                        now()->setMonth($this->selectedMonth)->format('F') . ' ' . $this->selectedYear,
                    'date' => now()->setMonth($this->selectedMonth)
                        ->setYear($this->selectedYear)->endOfMonth(),
                ]);
            }
        }

        // Notifikasi berhasil
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Gaji berhasil dicatat ke Cash Flow!',
        ]);
    }
}