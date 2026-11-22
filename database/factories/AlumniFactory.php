<?php

namespace Database\Factories;

use App\Models\Alumni;
use App\Models\AnakAsuh;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Alumni>
 */
class AlumniFactory extends Factory
{
    protected $model = Alumni::class;

    public function definition(): array
    {
        return [
            'anak_asuh_id' => AnakAsuh::factory(),
            'nama' => fake()->name(),
            'nama_panggilan' => fake()->firstName(),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'status_social_anak' => 'Yatim',
            'tanggal_keluar' => '2023-01-01',
            'pendidikan_terakhir' => 'SMA',
            'nama_sekolah_terakhir' => 'SMK Negeri 1',
            'pekerjaan' => 'Karyawan',
            'no_hp' => fake()->phoneNumber(),
            'alamat' => fake()->address(),
            'catatan' => 'Lulus dengan baik',
        ];
    }
}
