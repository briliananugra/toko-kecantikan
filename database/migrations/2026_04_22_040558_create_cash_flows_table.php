<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id(); // Primary key otomatis
            $table->enum('type', ['income', 'expense']); // Jenis: pemasukan atau pengeluaran
            $table->string('category'); // Kategori kas (penjualan, gaji, operasional, dll)
            $table->decimal('amount', 15, 2); // Jumlah uang
            $table->text('description')->nullable(); // Keterangan transaksi (opsional)
            $table->date('date'); // Tanggal transaksi kas
            $table->timestamps(); // Waktu dibuat & diupdate (otomatis Laravel)
        });
    }

    public function down(): void
    {
        // Hapus tabel jika migration dibatalkan
        Schema::dropIfExists('cash_flows');
    }
};