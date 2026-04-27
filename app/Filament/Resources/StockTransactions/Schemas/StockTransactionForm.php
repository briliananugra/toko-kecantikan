<?php

namespace App\Filament\Resources\StockTransactions\Schemas;

use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;

class StockTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Dropdown pilih produk (relasi ke tabel products)
                Select::make('product_id')
                    ->label('Produk')
                    ->options(Product::all()->pluck('name', 'id'))
                    ->required(),

                // Jenis transaksi: masuk atau keluar
                Select::make('type')
                    ->label('Jenis Transaksi')
                    ->options([
                        'in' => 'Barang Masuk',
                        'out' => 'Barang Keluar',
                    ])
                    ->required(),

                // Jumlah barang
                TextInput::make('quantity')
                    ->label('Jumlah')
                    ->numeric()
                    ->required(),

                // Harga per satuan saat transaksi
                TextInput::make('price_per_unit')
                    ->label('Harga Per Satuan')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                // Tanggal transaksi
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),

                // Keterangan tambahan (opsional)
                TextInput::make('note')
                    ->label('Keterangan')
                    ->maxLength(500),
            ]);
    }
}