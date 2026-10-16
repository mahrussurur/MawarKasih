<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_keuangan_bulanans', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('bulan');
            $table->bigInteger('saldo_awal')->default(0);
            $table->bigInteger('total_pemasukan')->default(0);
            $table->bigInteger('total_pengeluaran')->default(0);
            $table->bigInteger('saldo_akhir')->default(0);
            $table->string('status')->default('draft'); // draft, diajukan, dikembalikan, disetujui
            
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('submitted_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamp('returned_at')->nullable();
            $table->foreignId('returned_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->text('catatan_return')->nullable();
            
            $table->timestamps();

            $table->unique(['tahun', 'bulan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangan_bulanans');
    }
};
