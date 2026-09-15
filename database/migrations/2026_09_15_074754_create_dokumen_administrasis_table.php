<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumen_administrasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nomor_dokumen')->nullable();
            $table->string('jenis_dokumen')->nullable(); // misal: surat masuk, surat keluar, sk, dll
            $table->string('file_path');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->foreignId('diupload_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_administrasis');
    }
};
