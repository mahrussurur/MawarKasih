<?php
// MAHRUS
namespace Tests\Feature\Admin;

use App\Models\LaporanKeuanganBulanan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanKeuanganBulananCetakTest extends TestCase
{
    use RefreshDatabase;

    private function buatAdmin(): User
    {
        return User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    }

    public function test_admin_dapat_mencetak_laporan_keuangan_bulanan_dalam_format_pdf(): void
    {
        $admin = $this->buatAdmin();
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 5,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.laporan-bulanan.cetak', $laporan->id));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString('Laporan_Bulanan_2026_05.pdf', (string) $response->headers->get('Content-Disposition'));
    }

    public function test_mengembalikan_404_pada_cetak_jika_id_laporan_tidak_ditemukan(): void
    {
        $admin = $this->buatAdmin();

        $response = $this->actingAs($admin)->get(route('admin.laporan-bulanan.cetak', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_pada_cetak_jika_parameter_id_laporan_bukan_angka(): void
    {
        $admin = $this->buatAdmin();

        $response = $this->actingAs($admin)->get('/admin/laporan-bulanan/abc/cetak');

        $response->assertNotFound();
    }
}
