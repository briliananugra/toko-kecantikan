<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    // Kolom yang boleh diisi melalui form
    protected $fillable = [
        'type',        // Jenis: 'income' = pemasukan, 'expense' = pengeluaran
        'category',    // Kategori kas (penjualan, gaji, operasional, dll)
        'amount',      // Jumlah uang
        'description', // Keterangan transaksi
        'date',        // Tanggal transaksi kas
    ];

    // Memberitahu Laravel tipe data setiap kolom
    protected $casts = [
        'date' => 'date',        // Kolom date bertipe tanggal
        'amount' => 'decimal:2', // Jumlah uang bertipe desimal
    ];
}