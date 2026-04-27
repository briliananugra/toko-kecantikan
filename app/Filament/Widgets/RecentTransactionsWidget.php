<?php

namespace App\Filament\Widgets;

use App\Models\StockTransaction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTransactionsWidget extends BaseWidget
{
    // Judul widget
    protected static ?string $heading = 'Transaksi Stok Terbaru';

    // Urutan tampil di dashboard (setelah LowStockWidget)
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Ambil 10 transaksi terbaru
                StockTransaction::query()
                    ->latest('date')
                    ->limit(10)
            )
            ->columns([
                // Kolom nama produk (dari relasi)
                TextColumn::make('product.name')
                    ->label('Produk'),

                // Kolom jenis transaksi dengan badge warna
                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'in' => 'success',  // Hijau untuk masuk
                        'out' => 'danger',  // Merah untuk keluar
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'in' => 'Masuk',
                        'out' => 'Keluar',
                    }),

                // Kolom jumlah barang
                TextColumn::make('quantity')
                    ->label('Jumlah'),

                // Kolom tanggal transaksi
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y'),
            ]);
    }
}