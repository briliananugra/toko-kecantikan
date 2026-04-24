<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // Kolom yang boleh diisi melalui form
    protected $fillable = [
        'name',       // Nama lengkap karyawan
        'position',   // Jabatan karyawan (kasir, pramuniaga, dll)
        'salary',     // Gaji pokok per bulan
        'phone',      // Nomor HP karyawan
        'join_date',  // Tanggal mulai bekerja
        'status',     // Status karyawan: 'active' atau 'inactive'
    ];

    // Memberitahu Laravel tipe data setiap kolom
    protected $casts = [
        'join_date' => 'date',       // Kolom join_date bertipe tanggal
        'salary' => 'decimal:2',     // Gaji bertipe desimal
    ];

    // Relasi: satu karyawan punya banyak data presensi
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}