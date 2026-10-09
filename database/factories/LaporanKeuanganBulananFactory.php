<?php

namespace Database\Factories;

use App\Models\LaporanKeuanganBulanan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaporanKeuanganBulananFactory extends Factory
{
    protected $model = LaporanKeuanganBulanan::class;

    public function definition(): array
    {
        return [
            'tahun' => (int) date('Y'),
            'bulan' => (int) date('m'),
            'status' => 'draft',
            'saldo_awal' => 0,
            'total_pemasukan' => 0,
            'total_pengeluaran' => 0,
            'saldo_akhir' => 0,
        ];
    }
}
