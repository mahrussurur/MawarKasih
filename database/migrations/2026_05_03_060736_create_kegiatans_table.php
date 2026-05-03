<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id(); // Ini Primary Key otomatis

            // Kolom-kolom yang kita tambahkan:
            $table->string('nama_kegiatan');
            $table->date('tanggal_pelaksanaan');
            $table->text('deskripsi');
            $table->string('foto_dokumentasi')->nullable(); // 'nullable' artinya kolom ini boleh dikosongkan jika belum ada foto
            $table->timestamps(); // Ini otomatis mencatat kapan data dibuat dan diupdate
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
