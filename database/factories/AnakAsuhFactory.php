<?php

namespace Database\Factories;

use App\Models\AnakAsuh;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AnakAsuh>
 */
class AnakAsuhFactory extends Factory
{
    protected $model = AnakAsuh::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nama_panggilan' => fake()->firstName(),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->date('Y-m-d', '2015-01-01'),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'status_social_anak' => fake()->randomElement(['Yatim', 'Piatu', 'Yatim Piatu', 'Dhuafa']),
            'nama_ayah' => fake()->name('male'),
            'nama_ibu' => fake()->name('female'),
            'tinggal_di_lksa_sejak' => '2020',
            'sekolah' => 'SD Negeri 1 Banyuwangi',
            'kelas' => '5 SD',
        ];
    }
}
