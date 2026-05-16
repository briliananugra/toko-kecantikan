<?php

namespace App\Filament\Resources\CashFlows\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CashFlowsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom tanggal transaksi
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                // Kolom jenis transaksi dengan badge warna
                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'income' => 'success',
                        'expense' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    }),

                // Kolom kategori kas
                TextColumn::make('category')
                    ->label('Kategori')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'penjualan' => 'Penjualan',
                        'gaji' => 'Gaji Karyawan',
                        'pembelian_stok' => 'Pembelian Stok',
                        'operasional' => 'Operasional',
                        'lainnya' => 'Lainnya',
                    }),

                // Kolom jumlah uang
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),

                // Kolom keterangan
                TextColumn::make('description')
                    ->label('Keterangan')
                    ->limit(30),
            ])
            ->actions([
                // Tombol hapus dengan konfirmasi
                DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus yang dipilih'),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }
}