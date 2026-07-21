<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanKeuanganExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected Collection $transactions;

    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return ['Tanggal', 'Jenis', 'Kategori', 'Jumlah (Rp)', 'Keterangan'];
    }

    public function map($transaction): array
    {
        return [
            $transaction->date->format('d-m-Y'),
            $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
            ucfirst(str_replace('_', ' ', $transaction->category)),
            (float) $transaction->amount,
            $transaction->description ?? '-',
        ];
    }
}