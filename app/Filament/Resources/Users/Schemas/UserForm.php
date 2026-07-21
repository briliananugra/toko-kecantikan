<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Nama lengkap
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                // Email untuk login
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                // Password: wajib saat buat baru, opsional saat edit (kosongkan = tidak ganti)
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->minLength(8)
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->helperText('Kosongkan jika tidak ingin mengubah password.'),

                // Role menentukan akses menu
                Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'owner' => 'Owner',
                    ])
                    ->default('admin')
                    ->required()
                    ->helperText('Owner bisa akses semua menu. Admin tidak bisa akses Laporan Gaji & Laporan Keuangan.'),
            ]);
    }
}