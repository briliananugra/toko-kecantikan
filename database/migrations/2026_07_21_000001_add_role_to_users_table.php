<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role user: 'admin' (operasional harian) atau 'owner' (akses penuh)
            $table->enum('role', ['admin', 'owner'])->default('admin')->after('email');
        });

        // Jadikan akun admin@toko.com (akun utama yang sudah ada) sebagai Owner
        DB::table('users')
            ->where('email', 'admin@toko.com')
            ->update(['role' => 'owner']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};