<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration - membuat tabel users.
     * Field disesuaikan untuk sistem admin Panti Asuhan Mawar Kasih.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();                              // id (PK) - auto increment
            $table->string('name');                    // nama lengkap admin
            $table->string('username')->unique();      // username untuk login (unik)
            $table->string('password');                // password (akan di-hash)
            $table->timestamps();                      // created_at & updated_at
        });
    }

    /**
     * Batalkan migration - hapus tabel users.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};