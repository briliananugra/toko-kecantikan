<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Field input untuk nama kategori (wajib diisi)
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255),

                // Field input untuk deskripsi (opsional, pakai TextInput biasa)
                TextInput::make('description')
                    ->label('Deskripsi')
                    ->maxLength(500),
            ]);
    }
}