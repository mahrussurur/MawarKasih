<?php
// MAHRUS
namespace Tests\Feature\Admin;

use App\Http\Controllers\Admin\LaporanKeuanganBulananController;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionMethod;
use Tests\TestCase;

class LaporanKeuanganBulananGetDetailDataTest extends TestCase
{
    use RefreshDatabase;

    private function invokeGetLaporanDetailData(LaporanKeuanganBulanan $laporan): array
    {
        $controller = new LaporanKeuanganBulananController();
        $method = new ReflectionMethod(LaporanKeuanganBulananController::class, 'getLaporanDetailData');

        return $method->invoke($controller, $laporan);
    }

    public function test_mengambil_transaksi_hanya_pada_periode_bulan_dan_tahun_laporan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 5,
        ]);

        // Transaksi dalam bulan Mei 2026
        $tIn = TransaksiKeuangan::create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 500000,
            'keterangan'   => 'Donasi Masuk Mei',
            'tanggal'      => '2026-05-15',
            'dicatat_oleh' => $admin->id,
        ]);

        // Transaksi bulan sebelum (April 2026) dan sesudah (Juni 2026)
        TransaksiKeuangan::create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 300000,
            'keterangan'   => 'Donasi Masuk April',
            'tanggal'      => '2026-04-30',
            'dicatat_oleh' => $admin->id,
        ]);
        TransaksiKeuangan::create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'nominal'      => 200000,
            'keterangan'   => 'Operasional Juni',
            'tanggal'      => '2026-06-01',
            'dicatat_oleh' => $admin->id,
        ]);

        [$transaksis, $ringkasan] = $this->invokeGetLaporanDetailData($laporan);

        $this->assertCount(1, $transaksis);
        $this->assertEquals($tIn->id, $transaksis->first()->id);
        $this->assertEquals('Donasi Masuk Mei', $transaksis->first()->keterangan);
    }

    public function test_transaksi_diurutkan_berdasarkan_tanggal_secara_ascending(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 5,
        ]);

        TransaksiKeuangan::create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 100000,
            'keterangan'   => 'Transaksi Akhir Bulan',
            'tanggal'      => '2026-05-25',
            'dicatat_oleh' => $admin->id,
        ]);
        TransaksiKeuangan::create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'KONSUMSI',
            'nominal'      => 50000,
            'keterangan'   => 'Transaksi Awal Bulan',
            'tanggal'      => '2026-05-02',
            'dicatat_oleh' => $admin->id,
        ]);

        [$transaksis] = $this->invokeGetLaporanDetailData($laporan);

        $this->assertCount(2, $transaksis);
        $this->assertEquals('2026-05-02', $transaksis[0]->tanggal->toDateString());
        $this->assertEquals('2026-05-25', $transaksis[1]->tanggal->toDateString());
    }

    public function test_menghasilkan_ringkasan_total_nominal_dikelompokkan_berdasarkan_kategori_dan_jenis(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 5,
        ]);

        // Dua transaksi dengan kategori dan jenis yang sama
        TransaksiKeuangan::create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 500000,
            'keterangan'   => 'Donasi A',
            'tanggal'      => '2026-05-05',
            'dicatat_oleh' => $admin->id,
        ]);
        TransaksiKeuangan::create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 300000,
            'keterangan'   => 'Donasi B',
            'tanggal'      => '2026-05-10',
            'dicatat_oleh' => $admin->id,
        ]);

        // Satu transaksi dengan jenis dan kategori berbeda
        TransaksiKeuangan::create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'nominal'      => 200000,
            'keterangan'   => 'Listrik',
            'tanggal'      => '2026-05-12',
            'dicatat_oleh' => $admin->id,
        ]);

        [, $ringkasan] = $this->invokeGetLaporanDetailData($laporan);

        $this->assertCount(2, $ringkasan);

        $ringkasanDonasi = $ringkasan->firstWhere('kategori', 'DONASI');
        $this->assertNotNull($ringkasanDonasi);
        $this->assertEquals('pemasukan', $ringkasanDonasi->jenis);
        $this->assertEquals(800000, $ringkasanDonasi->total);

        $ringkasanOperasional = $ringkasan->firstWhere('kategori', 'OPERASIONAL');
        $this->assertNotNull($ringkasanOperasional);
        $this->assertEquals('pengeluaran', $ringkasanOperasional->jenis);
        $this->assertEquals(200000, $ringkasanOperasional->total);
    }

    public function test_mengembalikan_koleksi_kosong_jika_tidak_ada_transaksi_pada_periode_tersebut(): void
    {
        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun' => 2026,
            'bulan' => 5,
        ]);

        [$transaksis, $ringkasan] = $this->invokeGetLaporanDetailData($laporan);

        $this->assertCount(0, $transaksis);
        $this->assertCount(0, $ringkasan);
    }
}
