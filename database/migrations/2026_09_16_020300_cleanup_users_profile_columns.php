<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Keep users as an account-only table after all profile readers have moved
     * to profil_pengelola and profil_donatur.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->dropColumn([
                'name',
                'foto',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'jabatan',
                'jenis_kelamin',
                'no_hp',
            ]);
        });
    }

    /**
     * Restore only the schema for a rollback. Profile data remains the source
     * of truth and is deliberately not copied back into users.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('name')->nullable();
            $table->string('foto')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('jabatan')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->dropColumn('email_verified_at');
        });
    }
};
