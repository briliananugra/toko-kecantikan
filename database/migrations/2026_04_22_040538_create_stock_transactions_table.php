<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id(); // Primary key otomatis
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relasi ke tabel products
            $table->enum('type', ['in', 'out']); // Jenis transaksi: masuk atau keluar
            $table->integer('quantity'); // Jumlah barang yang masuk/keluar
            $table->decimal('price_per_unit', 15, 2); // Harga per satuan saat transaksi
            $table->text('note')->nullable(); // Keterangan tambahan (opsional)
            $table->date('date'); // Tanggal transaksi
            $table->timestamps(); // Waktu dibuat & diupdate (otomatis Laravel)
        });
    }

    public function down(): void
    {
        // Hapus tabel jika migration dibatalkan
        Schema::dropIfExists('stock_transactions');
    }
};