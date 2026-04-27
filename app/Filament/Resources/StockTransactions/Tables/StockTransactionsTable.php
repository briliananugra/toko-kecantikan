<?php

namespace App\Filament\Resources\StockTransactions\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StockTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom nama produk (dari relasi)
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable(),

                // Kolom jenis transaksi dengan badge warna
                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'in' => 'success',  // Hijau untuk barang masuk
                        'out' => 'danger',  // Merah untuk barang keluar
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'in' => 'Masuk',
                        'out' => 'Keluar',
                    }),

                // Kolom jumlah barang
                TextColumn::make('quantity')
                    ->label('Jumlah')
                    ->sortable(),

                // Kolom harga per satuan
                TextColumn::make('price_per_unit')
                    ->label('Harga Satuan')
                    ->money('IDR')
                    ->sortable(),

                // Kolom tanggal transaksi
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                // Kolom keterangan
                TextColumn::make('note')
                    ->label('Keterangan')
                    ->limit(30),
            ]);
    }
}