<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanGajiExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected array $salaryData;

    public function __construct(array $salaryData)
    {
        $this->salaryData = $salaryData;
    }

    public function array(): array
    {
        return array_map(fn ($data) => [
            $data['nama'],
            $data['jabatan'],
            $data['hari_hadir'],
            $data['hari_izin'],
            $data['hari_sakit'],
            $data['hari_alpha'],
            (float) $data['gaji_pokok'],
            (float) $data['potongan'],
            (float) $data['total_gaji'],
        ], $this->salaryData);
    }

    public function headings(): array
    {
        return ['Nama', 'Jabatan', 'Hadir', 'Izin', 'Sakit', 'Alpha', 'Gaji Pokok', 'Potongan', 'Total Gaji'];
    }
}