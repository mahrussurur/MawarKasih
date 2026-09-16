<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Donasi;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambahkan 'diterima' ke enum
        DB::statement("ALTER TABLE donasi MODIFY COLUMN status ENUM('pending', 'valid', 'ditolak', 'diterima') DEFAULT 'pending'");
        
        // 2. Ubah data lama
        Donasi::where('status', 'valid')->update(['status' => 'diterima']);
        
        // 3. Hapus 'valid' dari enum (MySQL akan error jika ada row dengan 'valid', tapi sudah kita update di langkah 2)
        DB::statement("ALTER TABLE donasi MODIFY COLUMN status ENUM('pending', 'diterima', 'ditolak') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE donasi MODIFY COLUMN status ENUM('pending', 'valid', 'ditolak', 'diterima') DEFAULT 'pending'");
        Donasi::where('status', 'diterima')->update(['status' => 'valid']);
        DB::statement("ALTER TABLE donasi MODIFY COLUMN status ENUM('pending', 'valid', 'ditolak') DEFAULT 'pending'");
    }
};
