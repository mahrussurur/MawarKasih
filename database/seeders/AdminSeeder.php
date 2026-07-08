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
            'name'     => 'Admin_mawar_kasih',
            'username' => 'admin_mawar_kasih',
            'email'    => 'admin1@gmail.com',
            'password' => Hash::make('tegaldlimo1'),
        ]);
    }
}