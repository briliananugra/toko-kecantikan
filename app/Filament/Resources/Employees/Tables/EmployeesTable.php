<?php

namespace App\Filament\Resources\Employees\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom nama karyawan
                TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                // Kolom jabatan
                TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable(),

                // Kolom gaji pokok
                TextColumn::make('salary')
                    ->label('Gaji Pokok')
                    ->money('IDR')
                    ->sortable(),

                // Kolom nomor HP
                TextColumn::make('phone')
                    ->label('Nomor HP'),

                // Kolom tanggal masuk kerja
                TextColumn::make('join_date')
                    ->label('Tanggal Masuk')
                    ->date('d M Y')
                    ->sortable(),

                // Kolom status dengan badge warna
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                    }),
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
            ]);
    }
}