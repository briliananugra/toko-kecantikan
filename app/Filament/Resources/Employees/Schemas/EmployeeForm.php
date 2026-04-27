<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Nama lengkap karyawan (wajib diisi)
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                // Jabatan karyawan (wajib diisi)
                TextInput::make('position')
                    ->label('Jabatan')
                    ->placeholder('Kasir, Pramuniaga, dll')
                    ->required()
                    ->maxLength(255),

                // Gaji pokok per bulan
                TextInput::make('salary')
                    ->label('Gaji Pokok')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                // Nomor HP karyawan (opsional)
                TextInput::make('phone')
                    ->label('Nomor HP')
                    ->tel()
                    ->maxLength(20),

                // Tanggal mulai bekerja
                DatePicker::make('join_date')
                    ->label('Tanggal Masuk Kerja')
                    ->required(),

                // Status karyawan aktif atau tidak
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }
}