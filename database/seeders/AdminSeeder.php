<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Buat akun admin default untuk pertama kali login.
     * Ganti password setelah login pertama!
     */
    public function run(): void
    {
        $admin = User::updateOrCreate([
            'username' => 'mawar kasih',
        ], [
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $admin->profilPengelola()->updateOrCreate([], [
            'nama' => 'Mawar Kasih',
            'jabatan' => 'Admin',
        ]);
    }
}
