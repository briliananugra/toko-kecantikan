<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockWidget extends BaseWidget
{
    // Judul widget
    protected static ?string $heading = 'Produk Stok Rendah';

    // Urutan tampil di dashboard (setelah StatsOverview)
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Ambil semua produk dengan stok kurang dari 10, diurutkan dari yang paling rendah
                Product::query()->where('stock', '<', 10)->orderBy('stock')
            )
            ->paginated([5]) // Tampil 5 per halaman, dengan tombol next untuk lihat sisanya
            ->columns([
                // Kolom nama produk
                TextColumn::make('name')
                    ->label('Nama Produk'),

                // Kolom kategori
                TextColumn::make('category.name')
                    ->label('Kategori'),

                // Kolom stok dengan warna merah kalau sangat rendah
                TextColumn::make('stock')
                    ->label('Stok')
                    ->color('danger'),

                // Kolom satuan
                TextColumn::make('unit')
                    ->label('Satuan'),
            ]);
    }
}