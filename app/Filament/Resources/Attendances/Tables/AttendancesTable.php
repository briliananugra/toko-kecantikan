<?php

namespace App\Filament\Resources\Attendances\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
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
                        'hadir' => 'success',
                        'izin' => 'warning',
                        'sakit' => 'info',
                        'alpha' => 'danger',
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
            ])
            ->actions([
                // Tombol hapus dengan konfirmasi
                DeleteAction::make()
                    ->label('Hapus')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus yang dipilih'),
                ]),
            ])
            ->defaultSort('date', 'desc');
            
    }
}