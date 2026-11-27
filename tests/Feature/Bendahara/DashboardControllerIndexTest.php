<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\LaporanKeuanganBulanan;
use App\Models\ProfilPegawai;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        $bendahara = User::factory()->create([
            'role'   => 'bendahara',
            'status' => 'aktif',
        ]);

        ProfilPegawai::create([
            'user_id' => $bendahara->id,
            'nama'    => 'Ibu Bendahara',
            'jabatan' => 'Bendahara Yayasan',
        ]);

        return $bendahara;
    }

    public function test_guest_dialihkan_ke_halaman_login(): void
    {
        $response = $this->get(route('bendahara.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_pengguna_non_bendahara_dilarang_mengakses_dashboard_bendahara(): void
    {
        foreach (['admin', 'ketua', 'donatur'] as $role) {
            $user = User::factory()->create(['role' => $role]);

            $response = $this->actingAs($user)->get(route('bendahara.dashboard'));

            $response->assertForbidden();
        }
    }

    public function test_bendahara_dapat_mengakses_dashboard_dalam_kondisi_data_kosong(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->get(route('bendahara.dashboard'));

        $response->assertOk();
        $response->assertViewIs('bendahara.dashboard');
        $response->assertViewHasAll([
            'totalPending',
            'totalDiterima',
            'totalDitolak',
            'totalNominal',
            'donasiTerbaru',
            'nominalPerBulan',
            'saldo',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'saldoBulanIni',
            'laporanCounts',
        ]);

        $this->assertSame(0, $response->viewData('totalPending'));
        $this->assertSame(0, $response->viewData('totalDiterima'));
        $this->assertSame(0, $response->viewData('totalDitolak'));
        $this->assertEquals(0, $response->viewData('totalNominal'));
        $this->assertEquals(0, $response->viewData('saldo'));
        $this->assertEquals(0, $response->viewData('pemasukanBulanIni'));
        $this->assertEquals(0, $response->viewData('pengeluaranBulanIni'));
        $this->assertEquals(0, $response->viewData('saldoBulanIni'));
        $this->assertCount(0, $response->viewData('donasiTerbaru'));
        $this->assertSame(array_fill(0, 12, 0.0), $response->viewData('nominalPerBulan'));
        $this->assertSame([
            'draft'        => 0,
            'diajukan'     => 0,
            'dikembalikan' => 0,
            'disetujui'    => 0,
        ], $response->viewData('laporanCounts'));
    }

    public function test_dashboard_menghitung_statistik_donasi_keuangan_dan_laporan_bulanan_dengan_akurat(): void
    {
        Carbon::setTestNow('2026-05-15 10:00:00');

        $bendahara = $this->buatBendahara();

        // Donasi berbagai status
        Donasi::factory()->create([
            'nominal' => 500000,
            'tanggal' => '2026-05-10',
            'status'  => 'pending',
        ]);
        Donasi::factory()->create([
            'nominal' => 1000000,
            'tanggal' => '2026-05-12',
            'status'  => 'diterima',
        ]);
        Donasi::factory()->create([
            'nominal' => 250000,
            'tanggal' => '2026-04-20',
            'status'  => 'diterima',
        ]);
        Donasi::factory()->create([
            'nominal' => 200000,
            'tanggal' => '2026-05-14',
            'status'  => 'ditolak',
        ]);

        // Transaksi keuangan bulan ini (Mei 2026) dan bulan sebelumnya (April 2026)
        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'nominal'      => 1000000,
            'tanggal'      => '2026-05-12',
            'dicatat_oleh' => $bendahara->id,
        ]);
        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pengeluaran',
            'nominal'      => 400000,
            'tanggal'      => '2026-05-13',
            'dicatat_oleh' => $bendahara->id,
        ]);
        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'nominal'      => 250000,
            'tanggal'      => '2026-04-20',
            'dicatat_oleh' => $bendahara->id,
        ]);

        // Laporan bulanan berbagai status
        LaporanKeuanganBulanan::factory()->create(['tahun' => 2026, 'bulan' => 1, 'status' => 'draft']);
        LaporanKeuanganBulanan::factory()->create(['tahun' => 2026, 'bulan' => 2, 'status' => 'diajukan']);
        LaporanKeuanganBulanan::factory()->create(['tahun' => 2026, 'bulan' => 3, 'status' => 'dikembalikan']);
        LaporanKeuanganBulanan::factory()->create(['tahun' => 2026, 'bulan' => 4, 'status' => 'disetujui']);

        $response = $this->actingAs($bendahara)->get(route('bendahara.dashboard'));

        $response->assertOk();
        $this->assertSame(1, $response->viewData('totalPending'));
        $this->assertSame(2, $response->viewData('totalDiterima'));
        $this->assertSame(1, $response->viewData('totalDitolak'));
        $this->assertEquals(1250000, $response->viewData('totalNominal'));

        // Saldo keseluruhan vs bulan ini
        $this->assertEquals(850000, $response->viewData('saldo'));
        $this->assertEquals(1000000, $response->viewData('pemasukanBulanIni'));
        $this->assertEquals(400000, $response->viewData('pengeluaranBulanIni'));
        $this->assertEquals(600000, $response->viewData('saldoBulanIni'));

        // Grafik nominal per bulan (index 3 = April, index 4 = Mei)
        $nominalPerBulan = $response->viewData('nominalPerBulan');
        $this->assertSame(250000.0, $nominalPerBulan[3]);
        $this->assertSame(1000000.0, $nominalPerBulan[4]);

        $this->assertSame([
            'draft'        => 1,
            'diajukan'     => 1,
            'dikembalikan' => 1,
            'disetujui'    => 1,
        ], $response->viewData('laporanCounts'));

        Carbon::setTestNow();
    }

    public function test_donasi_terbaru_dibatasi_maksimal_5_donasi_berstatus_pending(): void
    {
        $bendahara = $this->buatBendahara();

        Donasi::factory()->count(7)->create(['status' => 'pending']);
        Donasi::factory()->count(2)->create(['status' => 'diterima']);

        $response = $this->actingAs($bendahara)->get(route('bendahara.dashboard'));

        $response->assertOk();
        $donasiTerbaru = $response->viewData('donasiTerbaru');

        $this->assertCount(5, $donasiTerbaru);
        $this->assertTrue($donasiTerbaru->every(fn ($donasi) => $donasi->status === 'pending'));
    }
}
