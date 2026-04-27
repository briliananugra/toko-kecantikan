<?php

namespace App\Filament\Resources\Attendances\Schemas;

use App\Models\Employee;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Dropdown pilih karyawan (relasi ke tabel employees)
                Select::make('employee_id')
                    ->label('Karyawan')
                    ->options(Employee::where('status', 'active')->pluck('name', 'id'))
                    ->required(),

                // Tanggal presensi
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),

                // Status kehadiran
                Select::make('status')
                    ->label('Status Kehadiran')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpha' => 'Alpha',
                    ])
                    ->required(),

                // Keterangan tambahan (opsional)
                TextInput::make('note')
                    ->label('Keterangan')
                    ->maxLength(500),
            ]);
    }
}