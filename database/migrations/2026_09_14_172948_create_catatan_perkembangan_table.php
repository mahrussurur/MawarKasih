<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catatan_perkembangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_asuh_id')->constrained('anak_asuh')->onDelete('cascade');
            $table->foreignId('pengasuh_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tanggal');
            $table->enum('kategori', ['Pendidikan', 'Kesehatan', 'Sosial', 'Lainnya'])->default('Lainnya');
            $table->text('catatan');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catatan_perkembangan');
    }
};
