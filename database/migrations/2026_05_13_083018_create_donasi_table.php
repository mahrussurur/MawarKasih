<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel donasi — mencatat semua pemasukan donasi ke Panti Asuhan Mawar Kasih.
     * Kode donasi digenerate otomatis, tanggal otomatis saat input.
     */
    public function up(): void
    {
        Schema::create('donasi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_donasi')->unique();          // DON-YYYYMMDD-XXXX (auto generate)
            $table->string('nama_donatur');
            $table->string('no_hp', 20)->nullable();
            $table->unsignedBigInteger('nominal');            // dalam rupiah
            $table->date('tanggal');                          // otomatis terisi saat input
            $table->string('bukti_transfer')->nullable();     // path file gambar
            $table->enum('status', ['pending', 'valid', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable();        // alasan ditolak, dll
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};