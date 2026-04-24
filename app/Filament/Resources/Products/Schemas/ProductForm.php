<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Dropdown pilih kategori (relasi ke tabel categories)
                Select::make('category_id')
                    ->label('Kategori')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->required(),

                // Nama produk (wajib diisi)
                TextInput::make('name')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(255),

                // Harga beli per satuan
                TextInput::make('purchase_price')
                    ->label('Harga Beli')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                // Harga jual di toko
                TextInput::make('selling_price')
                    ->label('Harga Jual')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                // Jumlah stok saat ini
                TextInput::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->default(0)
                    ->required(),

                // Satuan barang
                TextInput::make('unit')
                    ->label('Satuan')
                    ->placeholder('pcs, botol, lusin, dll')
                    ->required(),

                // Keterangan produk (opsional)
                TextInput::make('description')
                    ->label('Deskripsi')
                    ->maxLength(500),
            ]);
    }
}