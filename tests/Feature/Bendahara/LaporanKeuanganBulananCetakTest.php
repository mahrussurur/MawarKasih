<?php

namespace Tests\Feature\Bendahara;

use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanKeuanganBulananCetakTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_dapat_mencetak_laporan_keuangan_bulanan_dalam_format_pdf(): void
    {
        $bendahara = $this->buatBendahara();
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 5,
            'status' => 'disetujui',
        ]);

        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 500000,
            'tanggal'      => '2026-05-10',
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->get(route('bendahara.laporan-bulanan.cetak', $laporan->id));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString(
            'Laporan_Bulanan_2026_05.pdf',
            (string) $response->headers->get('Content-Disposition')
        );
    }

    public function test_mengembalikan_404_pada_cetak_jika_id_laporan_tidak_ditemukan(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->get(route('bendahara.laporan-bulanan.cetak', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_pada_cetak_jika_parameter_id_laporan_bukan_angka(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->get('/bendahara/laporan-bulanan/abc/cetak');

        $response->assertNotFound();
    }
}
