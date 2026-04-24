<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom nama kategori
                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),

                // Kolom deskripsi kategori
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50), // Batasi tampilan 50 karakter

                // Kolom tanggal dibuat
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y')
                    ->sortable(),
            ]);
    }
}