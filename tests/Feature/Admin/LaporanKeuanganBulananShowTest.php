<?php
// MAHRUS
namespace Tests\Feature\Admin;

use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanKeuanganBulananShowTest extends TestCase
{
    use RefreshDatabase;

    private function buatAdmin(): User
    {
        return User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    }

    public function test_admin_dapat_melihat_detail_laporan_keuangan_bulanan_dengan_view_yang_benar(): void
    {
        $admin = $this->buatAdmin();
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 5,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.laporan-bulanan.show', $laporan->id));

        $response->assertOk();
        $response->assertViewIs('admin.laporan-bulanan.show');
        $response->assertViewHasAll(['laporan', 'transaksis', 'ringkasan']);
        $response->assertSee('Mei 2026');
    }

    public function test_detail_laporan_memuat_transaksi_dan_ringkasan_sesuai_periode_bulan(): void
    {
        $admin = $this->buatAdmin();
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 5,
        ]);

        // Transaksi di dalam bulan Mei 2026
        TransaksiKeuangan::create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 500000,
            'keterangan'   => 'Donasi Bulan Mei',
            'tanggal'      => '2026-05-10',
            'dicatat_oleh' => $admin->id,
        ]);

        // Transaksi di luar bulan Mei 2026 (Juni 2026)
        TransaksiKeuangan::create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'nominal'      => 200000,
            'keterangan'   => 'Operasional Bulan Juni',
            'tanggal'      => '2026-06-01',
            'dicatat_oleh' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.laporan-bulanan.show', $laporan->id));

        $response->assertOk();
        $transaksis = $response->viewData('transaksis');
        $this->assertCount(1, $transaksis);
        $this->assertEquals('Donasi Bulan Mei', $transaksis->first()->keterangan);

        $ringkasan = $response->viewData('ringkasan');
        $this->assertCount(1, $ringkasan);
        $this->assertEquals('DONASI', $ringkasan->first()->kategori);
        $this->assertEquals(500000, $ringkasan->first()->total);
    }

    public function test_mengembalikan_404_jika_id_laporan_tidak_ditemukan(): void
    {
        $admin = $this->buatAdmin();

        $response = $this->actingAs($admin)->get(route('admin.laporan-bulanan.show', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_parameter_id_laporan_bukan_angka(): void
    {
        $admin = $this->buatAdmin();

        $response = $this->actingAs($admin)->get('/admin/laporan-bulanan/abc');

        $response->assertNotFound();
    }
}
