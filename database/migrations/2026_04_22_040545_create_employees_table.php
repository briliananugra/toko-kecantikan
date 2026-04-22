<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Primary key otomatis
            $table->string('name'); // Nama lengkap karyawan
            $table->string('position'); // Jabatan karyawan (kasir, pramuniaga, dll)
            $table->decimal('salary', 15, 2); // Gaji pokok per bulan
            $table->string('phone')->nullable(); // Nomor HP karyawan (opsional)
            $table->date('join_date'); // Tanggal mulai bekerja
            $table->enum('status', ['active', 'inactive'])->default('active'); // Status karyawan aktif/tidak
            $table->timestamps(); // Waktu dibuat & diupdate (otomatis Laravel)
        });
    }

    public function down(): void
    {
        // Hapus tabel jika migration dibatalkan
        Schema::dropIfExists('employees');
    }
};