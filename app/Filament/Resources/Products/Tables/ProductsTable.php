<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom nama produk
                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable(),

                // Kolom nama kategori (dari relasi)
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),

                // Kolom harga beli
                TextColumn::make('purchase_price')
                    ->label('Harga Beli')
                    ->money('IDR')
                    ->sortable(),

                // Kolom harga jual
                TextColumn::make('selling_price')
                    ->label('Harga Jual')
                    ->money('IDR')
                    ->sortable(),

                // Kolom stok saat ini
                TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable(),

                // Kolom satuan barang
                TextColumn::make('unit')
                    ->label('Satuan'),
            ]);
    }
}