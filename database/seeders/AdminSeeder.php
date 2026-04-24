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
        User::create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);
    }
}