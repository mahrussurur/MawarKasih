<?php
// MAHRUS
namespace Tests\Feature\Admin;

use App\Models\LaporanKeuanganBulanan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanKeuanganBulananIndexTest extends TestCase
{
    use RefreshDatabase;

    private function buatAdmin(): User
    {
        return User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    }

    public function test_admin_dapat_menampilkan_halaman_daftar_laporan_keuangan_bulanan_dengan_view_yang_benar(): void
    {
        $admin = $this->buatAdmin();
        LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 5,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.laporan-bulanan.index'));

        $response->assertOk();
        $response->assertViewIs('admin.laporan-bulanan.index');
        $response->assertViewHas('laporans');
        $response->assertSee('Daftar Laporan Keuangan');
    }

    public function test_admin_dapat_memfilter_laporan_bulanan_berdasarkan_status(): void
    {
        $admin = $this->buatAdmin();

        LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 1,
            'status' => 'diajukan',
        ]);

        LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 2,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.laporan-bulanan.index', ['status' => 'diajukan']));

        $response->assertOk();
        $laporans = $response->viewData('laporans');
        $this->assertCount(1, $laporans);
        $this->assertEquals('diajukan', $laporans->first()->status);
    }

    public function test_laporan_bulanan_diurutkan_berdasarkan_tahun_dan_bulan_terbaru(): void
    {
        $admin = $this->buatAdmin();

        LaporanKeuanganBulanan::factory()->create(['tahun' => 2025, 'bulan' => 12]);
        LaporanKeuanganBulanan::factory()->create(['tahun' => 2026, 'bulan' => 1]);
        LaporanKeuanganBulanan::factory()->create(['tahun' => 2026, 'bulan' => 5]);

        $response = $this->actingAs($admin)->get(route('admin.laporan-bulanan.index'));

        $response->assertOk();
        $laporans = $response->viewData('laporans');
        $urutan = $laporans->map(fn ($lap) => "{$lap->tahun}-{$lap->bulan}")->all();

        $this->assertEquals(['2026-5', '2026-1', '2025-12'], $urutan);
    }

    public function test_data_laporan_bulanan_dibatasi_12_item_per_halaman_pagination(): void
    {
        $admin = $this->buatAdmin();

        for ($i = 1; $i <= 15; $i++) {
            LaporanKeuanganBulanan::factory()->create([
                'tahun' => 2025 + intdiv($i, 12),
                'bulan' => ($i % 12) + 1,
            ]);
        }

        $response = $this->actingAs($admin)->get(route('admin.laporan-bulanan.index'));

        $response->assertOk();
        $laporans = $response->viewData('laporans');
        $this->assertCount(12, $laporans);
        $this->assertEquals(15, $laporans->total());
    }
}
