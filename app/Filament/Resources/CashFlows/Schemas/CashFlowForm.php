<?php

namespace App\Filament\Resources\CashFlows\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CashFlowForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Jenis transaksi kas: pemasukan atau pengeluaran
                Select::make('type')
                    ->label('Jenis')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    ])
                    ->required(),

                // Kategori kas
                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'penjualan' => 'Penjualan',
                        'gaji' => 'Gaji Karyawan',
                        'pembelian_stok' => 'Pembelian Stok',
                        'operasional' => 'Operasional',
                        'lainnya' => 'Lainnya',
                    ])
                    ->required(),

                // Jumlah uang
                TextInput::make('amount')
                    ->label('Jumlah')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                // Tanggal transaksi kas
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),

                // Keterangan transaksi (opsional)
                TextInput::make('description')
                    ->label('Keterangan')
                    ->maxLength(500),
            ]);
    }
}