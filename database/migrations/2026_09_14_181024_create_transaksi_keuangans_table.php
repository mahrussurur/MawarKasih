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
        Schema::create('transaksi_keuangans', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['pemasukan', 'pengeluaran']);
            $table->string('kategori')->default('LAINNYA');
            $table->decimal('nominal', 15, 2);
            $table->string('keterangan');
            $table->string('bukti_transaksi')->nullable();
            $table->date('tanggal');
            
            // Relasi ke donasi opsional jika pemasukan bersumber dari donasi
            $table->foreignId('donasi_id')->nullable()->constrained('donasi')->cascadeOnDelete();
            
            // Siapa yang mencatat
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_keuangans');
    }
};
