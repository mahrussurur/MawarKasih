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
        Schema::table('transaksi_keuangans', function (Blueprint $table) {
            $table->dropForeign(['donasi_id']);
            $table->foreign('donasi_id')->references('id')->on('donasi')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_keuangans', function (Blueprint $table) {
            $table->dropForeign(['donasi_id']);
            $table->foreign('donasi_id')->references('id')->on('donasi')->nullOnDelete();
        });
    }
};
