<?php

namespace Database\Factories;

use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiKeuanganFactory extends Factory
{
    protected $model = TransaksiKeuangan::class;

    public function definition(): array
    {
        return [
            'jenis' => 'pemasukan',
            'nominal' => $this->faker->numberBetween(50000, 500000),
            'keterangan' => $this->faker->sentence,
            'tanggal' => $this->faker->date(),
            'kategori' => 'DONASI',
            'dicatat_oleh' => User::factory()->create(['role' => 'bendahara'])->id,
        ];
    }
}
