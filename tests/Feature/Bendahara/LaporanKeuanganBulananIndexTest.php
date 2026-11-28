<?php

namespace Tests\Feature\Bendahara;

use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class LaporanKeuanganBulananIndexTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_dapat_menampilkan_laporan_periode_saat_ini_secara_default(): void
    {
        Carbon::setTestNow('2026-05-15 10:00:00');
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->get(route('bendahara.laporan-bulanan.index'));

        $response->assertOk();
        $response->assertViewIs('bendahara.laporan-bulanan.index');
        $response->assertViewHasAll(['laporan', 'tahun', 'bulan']);
        $this->assertSame(2026, $response->viewData('tahun'));
        $this->assertSame(5, $response->viewData('bulan'));

        $this->assertDatabaseHas('laporan_keuangan_bulanans', [
            'tahun'  => 2026,
            'bulan'  => 5,
            'status' => 'draft',
        ]);

        Carbon::setTestNow();
    }

    public function test_bendahara_dapat_memilih_periode_tertentu_dan_mengkalkulasi_saldo_otomatis(): void
    {
        $bendahara = $this->buatBendahara();

        // Saldo bulan sebelumnya (April 2026)
        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'nominal'      => 300000,
            'tanggal'      => '2026-04-20',
            'dicatat_oleh' => $bendahara->id,
        ]);

        // Mutasi bulan berjalan (Mei 2026)
        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'nominal'      => 500000,
            'tanggal'      => '2026-05-10',
            'dicatat_oleh' => $bendahara->id,
        ]);
        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pengeluaran',
            'nominal'      => 150000,
            'tanggal'      => '2026-05-12',
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->get(route('bendahara.laporan-bulanan.index', [
            'tahun' => 2026,
            'bulan' => 5,
        ]));

        $response->assertOk();
        $laporan = $response->viewData('laporan');
        $this->assertEquals(300000, $laporan->saldo_awal);
        $this->assertEquals(500000, $laporan->total_pemasukan);
        $this->assertEquals(150000, $laporan->total_pengeluaran);
        $this->assertEquals(650000, $laporan->saldo_akhir);
    }

    public function test_laporan_berstatus_diajukan_atau_disetujui_tidak_dikalkulasi_ulang(): void
    {
        $bendahara = $this->buatBendahara();

        LaporanKeuanganBulanan::factory()->create([
            'tahun'             => 2026,
            'bulan'             => 5,
            'status'            => 'disetujui',
            'saldo_awal'        => 0,
            'total_pemasukan'   => 100000,
            'total_pengeluaran' => 0,
            'saldo_akhir'       => 100000,
        ]);

        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'nominal'      => 900000,
            'tanggal'      => '2026-05-15',
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->get(route('bendahara.laporan-bulanan.index', [
            'tahun' => 2026,
            'bulan' => 5,
        ]));

        $response->assertOk();
        $laporan = $response->viewData('laporan');
        $this->assertEquals('disetujui', $laporan->status);
        $this->assertEquals(100000, $laporan->total_pemasukan);
        $this->assertEquals(100000, $laporan->saldo_akhir);
    }

    public function test_guest_dan_pengguna_non_bendahara_dilarang_mengakses_laporan_bulanan(): void
    {
        $this->get(route('bendahara.laporan-bulanan.index'))
            ->assertRedirect(route('login'));

        $donatur = User::factory()->create(['role' => 'donatur']);
        $this->actingAs($donatur)
            ->get(route('bendahara.laporan-bulanan.index'))
            ->assertForbidden();
    }
}
