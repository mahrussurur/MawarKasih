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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_asuh_id')->unique()->constrained('anak_asuh')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('foto')->nullable();
            $table->string('nama');
            $table->string('nama_panggilan')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('status_social_anak');
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('tinggal_di_lksa_sejak')->nullable();
            $table->string('sekolah')->nullable();
            $table->string('kelas')->nullable();
            $table->date('tanggal_keluar');
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('nama_sekolah_terakhir')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
