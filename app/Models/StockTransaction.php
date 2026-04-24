<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    // Kolom yang boleh diisi melalui form
    protected $fillable = [
        'product_id',     // ID produk (relasi ke tabel products)
        'type',           // Jenis transaksi: 'in' = masuk, 'out' = keluar
        'quantity',       // Jumlah barang yang masuk/keluar
        'price_per_unit', // Harga per satuan saat transaksi
        'note',           // Keterangan tambahan
        'date',           // Tanggal transaksi
    ];

    // Memberitahu Laravel tipe data setiap kolom
    protected $casts = [
        'date' => 'date',                    // Kolom date bertipe tanggal
        'price_per_unit' => 'decimal:2',     // Harga bertipe desimal
    ];

    // Relasi: transaksi ini milik satu produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}