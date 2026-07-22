<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\CashFlow;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    // Tampil setelah kotak tanggal, sebelum grafik tren kas
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        // Hitung total semua stok barang
        $totalStock = Product::sum('stock');

        // Hitung total pemasukan hari ini
        $todayIncome = CashFlow::where('type', 'income')
            ->whereDate('date', today())
            ->sum('amount');

        // Hitung total pengeluaran hari ini
        $todayExpense = CashFlow::where('type', 'expense')
            ->whereDate('date', today())
            ->sum('amount');

        // Hitung jumlah karyawan hadir hari ini
        $todayAttendance = Attendance::where('status', 'hadir')
            ->whereDate('date', today())
            ->count();

        return [
            // Kartu total stok barang
            Stat::make('Total Stok Barang', $totalStock . ' item')
                ->description('Total semua barang di gudang')
                ->color('primary'),

            // Kartu pemasukan hari ini
            Stat::make('Pemasukan Hari Ini', 'Rp ' . number_format($todayIncome, 0, ',', '.'))
                ->description('Total pemasukan hari ini')
                ->color('success'),

            // Kartu pengeluaran hari ini
            Stat::make('Pengeluaran Hari Ini', 'Rp ' . number_format($todayExpense, 0, ',', '.'))
                ->description('Total pengeluaran hari ini')
                ->color('danger'),

            // Kartu karyawan hadir hari ini
            Stat::make('Karyawan Hadir', $todayAttendance . ' orang')
                ->description('Jumlah karyawan hadir hari ini')
                ->color('warning'),
        ];
    }
}