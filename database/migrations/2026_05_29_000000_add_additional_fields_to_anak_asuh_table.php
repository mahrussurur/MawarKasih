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
        Schema::table('anak_asuh', function (Blueprint $table) {
            $table->string('nama_panggilan')->nullable()->after('nama');
            $table->string('tinggal_di_lksa_sejak')->nullable()->after('nama_ibu');
            $table->string('sekolah')->nullable()->after('tinggal_di_lksa_sejak');
            $table->string('kelas')->nullable()->after('sekolah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anak_asuh', function (Blueprint $table) {
            $table->dropColumn(['nama_panggilan', 'tinggal_di_lksa_sejak', 'sekolah', 'kelas']);
        });
    }
};
