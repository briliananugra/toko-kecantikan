<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom nama karyawan (dari relasi)
                TextColumn::make('employee.name')
                    ->label('Nama Karyawan')
                    ->searchable()
                    ->sortable(),

                // Kolom tanggal presensi
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                // Kolom status kehadiran dengan badge warna
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'hadir' => 'success',  // Hijau untuk hadir
                        'izin' => 'warning',   // Kuning untuk izin
                        'sakit' => 'info',     // Biru untuk sakit
                        'alpha' => 'danger',   // Merah untuk alpha
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpha' => 'Alpha',
                    }),

                // Kolom keterangan
                TextColumn::make('note')
                    ->label('Keterangan')
                    ->limit(30),
            ]);
    }
}