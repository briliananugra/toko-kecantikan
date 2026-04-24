<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Kolom yang boleh diisi melalui form
    protected $fillable = [
        'category_id',  // ID kategori (relasi ke tabel categories)
        'name',         // Nama produk
        'purchase_price', // Harga beli per satuan
        'selling_price',  // Harga jual di toko
        'stock',          // Jumlah stok saat ini
        'unit',           // Satuan barang (pcs, botol, dll)
        'description',    // Keterangan produk
    ];

    // Memberitahu Laravel bahwa kolom harga bertipe desimal/angka
    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
    ];

    // Relasi: produk ini milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: satu produk punya banyak riwayat transaksi stok
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }
}