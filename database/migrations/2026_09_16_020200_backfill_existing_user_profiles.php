<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Copy existing profile attributes from users without removing the legacy source.
     */
    public function up(): void
    {
        DB::table('users')
            ->whereIn('role', ['admin', 'bendahara', 'sekretaris', 'pengasuh'])
            ->chunkById(100, function ($users): void {
                foreach ($users as $user) {
                    DB::table('profil_pengelola')->insertOrIgnore([
                        'user_id' => $user->id,
                        'foto' => $user->foto,
                        'nama' => $user->name,
                        'tempat_lahir' => $user->tempat_lahir,
                        'tanggal_lahir' => $user->tanggal_lahir,
                        'jabatan' => $user->jabatan,
                        'jenis_kelamin' => $user->jenis_kelamin,
                        'no_hp' => $user->no_hp,
                        'alamat' => $user->alamat,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ]);
                }
            });

        DB::table('users')
            ->where('role', 'donatur')
            ->chunkById(100, function ($users): void {
                foreach ($users as $user) {
                    DB::table('profil_donatur')->insertOrIgnore([
                        'user_id' => $user->id,
                        'nama' => $user->name,
                        'no_hp' => $user->no_hp,
                        'alamat' => $user->alamat,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ]);
                }
            });
    }

    /**
     * Backfill is intentionally not reversed independently, so existing profile data
     * is never deleted by rolling back only this migration.
     */
    public function down(): void
    {
        // No-op.
    }
};
