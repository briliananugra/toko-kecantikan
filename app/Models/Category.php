<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Kolom yang boleh diisi melalui form
    protected $fillable = [
        'name',
        'description',
    ];

    // Relasi: satu kategori punya banyak produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}