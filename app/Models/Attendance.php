<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // Kolom yang boleh diisi melalui form
    protected $fillable = [
        'employee_id', // ID karyawan (relasi ke tabel employees)
        'date',        // Tanggal presensi
        'status',      // Status: 'hadir', 'izin', 'sakit', 'alpha'
        'note',        // Keterangan tambahan (opsional)
    ];

    // Memberitahu Laravel tipe data setiap kolom
    protected $casts = [
        'date' => 'date', // Kolom date bertipe tanggal
    ];

    // Relasi: presensi ini milik satu karyawan
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}