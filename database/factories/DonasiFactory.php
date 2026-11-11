<?php

namespace Database\Factories;

use App\Models\Donasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class DonasiFactory extends Factory
{
    protected $model = Donasi::class;

    public function definition(): array
    {
        return [
            'kode_donasi' => Donasi::generateKode(),
            'nama_donatur' => fake()->name(),
            'email' => fake()->safeEmail(),
            'alamat' => fake()->address(),
            'no_hp' => '081234567890',
            'nominal' => 100000,
            'tanggal' => now()->toDateString(),
            'bukti_transfer' => null,
            'status' => 'pending',
            'catatan_admin' => null,
            'keterangan' => 'Donasi sukarela',
            'metode_pembayaran' => 'transfer_bca',
            'tampilkan_nama' => 'nama_asli',
            'donatur_id' => null,
        ];
    }
}
