<?php

namespace Database\Factories;

use App\Models\ArsipDokumen;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArsipDokumenFactory extends Factory
{
    protected $model = ArsipDokumen::class;

    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(3),
            'nomor_dokumen' => 'DOC/' . fake()->numerify('####/2026'),
            'kategori' => 'Legalitas',
            'tanggal_dokumen' => now()->toDateString(),
            'deskripsi' => fake()->paragraph(),
            'file_name_asli' => 'dokumen.pdf',
            'file_path' => 'arsip-dokumen/sample.pdf',
            'file_size' => 10240,
            'mime_type' => 'application/pdf',
            'uploaded_by' => null,
        ];
    }
}
