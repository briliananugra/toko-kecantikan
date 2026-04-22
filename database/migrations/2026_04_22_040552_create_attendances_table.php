<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id(); // Primary key otomatis
            $table->foreignId('employee_id')->constrained()->onDelete('cascade'); // Relasi ke tabel employees
            $table->date('date'); // Tanggal presensi
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha']); // Status kehadiran karyawan
            $table->text('note')->nullable(); // Keterangan tambahan (opsional)
            $table->timestamps(); // Waktu dibuat & diupdate (otomatis Laravel)
        });
    }

    public function down(): void
    {
        // Hapus tabel jika migration dibatalkan
        Schema::dropIfExists('attendances');
    }
};