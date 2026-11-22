<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'username' => 'mawar kasih',
        ], [
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'status' => 'aktif',
        ]);

        $admin->profilPegawai()->firstOrCreate([], [
            'nama' => 'Mawar Kasih',
            'jabatan' => 'Admin',
        ]);
    }
}
