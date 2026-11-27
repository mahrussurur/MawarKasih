<?php
// MAHRUS
namespace Tests\Feature\Admin;

use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KeuanganIndexTest extends TestCase
{
    use RefreshDatabase;

    private function buatAdmin(): User
    {
        return User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    }

    public function test_admin_dapat_menampilkan_halaman_transaksi_keuangan_dengan_view_dan_kalkulasi_saldo_yang_benar(): void
    {
        $admin = $this->buatAdmin();

        TransaksiKeuangan::create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 1500000,
            'keterangan'   => 'Donasi Rutin A',
            'tanggal'      => '2026-05-01',
            'dicatat_oleh' => $admin->id,
        ]);

        TransaksiKeuangan::create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'nominal'      => 500000,
            'keterangan'   => 'Biaya Operasional',
            'tanggal'      => '2026-05-02',
            'dicatat_oleh' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.keuangan.index'));

        $response->assertOk();
        $response->assertViewIs('admin.keuangan.index');
        $response->assertViewHasAll(['transaksi', 'totalPemasukan', 'totalPengeluaran', 'saldo']);
        $this->assertEquals(1500000, $response->viewData('totalPemasukan'));
        $this->assertEquals(500000, $response->viewData('totalPengeluaran'));
        $this->assertEquals(1000000, $response->viewData('saldo'));
        $response->assertSee('Donasi Rutin A');
    }

    public function test_admin_dapat_memfilter_transaksi_berdasarkan_jenis_pemasukan_atau_pengeluaran(): void
    {
        $admin = $this->buatAdmin();

        TransaksiKeuangan::create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 1000000,
            'keterangan'   => 'Pemasukan Kas Yayasan',
            'tanggal'      => '2026-05-10',
            'dicatat_oleh' => $admin->id,
        ]);

        TransaksiKeuangan::create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'KONSUMSI',
            'nominal'      => 200000,
            'keterangan'   => 'Beli Konsumsi Anak Asuh',
            'tanggal'      => '2026-05-11',
            'dicatat_oleh' => $admin->id,
        ]);

        // Filter Pemasukan
        $responsePemasukan = $this->actingAs($admin)->get(route('admin.keuangan.index', ['jenis' => 'pemasukan']));
        $responsePemasukan->assertOk();
        $responsePemasukan->assertSee('Pemasukan Kas Yayasan');
        $responsePemasukan->assertDontSee('Beli Konsumsi Anak Asuh');
        $this->assertCount(1, $responsePemasukan->viewData('transaksi'));

        // Filter Pengeluaran
        $responsePengeluaran = $this->actingAs($admin)->get(route('admin.keuangan.index', ['jenis' => 'pengeluaran']));
        $responsePengeluaran->assertOk();
        $responsePengeluaran->assertSee('Beli Konsumsi Anak Asuh');
        $responsePengeluaran->assertDontSee('Pemasukan Kas Yayasan');
        $this->assertCount(1, $responsePengeluaran->viewData('transaksi'));
    }

    public function test_admin_dapat_mencari_transaksi_berdasarkan_keterangan(): void
    {
        $admin = $this->buatAdmin();

        TransaksiKeuangan::create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'PENDIDIKAN',
            'nominal'      => 350000,
            'keterangan'   => 'Beli Buku Tulis Sekolah',
            'tanggal'      => '2026-05-12',
            'dicatat_oleh' => $admin->id,
        ]);

        TransaksiKeuangan::create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'KESEHATAN',
            'nominal'      => 150000,
            'keterangan'   => 'Obat P3K Anak Asuh',
            'tanggal'      => '2026-05-13',
            'dicatat_oleh' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.keuangan.index', ['search' => 'Buku Tulis']));

        $response->assertOk();
        $this->assertCount(1, $response->viewData('transaksi'));
        $response->assertSee('Beli Buku Tulis Sekolah');
        $response->assertDontSee('Obat P3K Anak Asuh');
    }

    public function test_admin_dapat_menggabungkan_filter_jenis_dan_pencarian_keterangan(): void
    {
        $admin = $this->buatAdmin();

        TransaksiKeuangan::create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'nominal'      => 400000,
            'keterangan'   => 'Listrik Gedung Utama',
            'tanggal'      => '2026-05-15',
            'dicatat_oleh' => $admin->id,
        ]);

        TransaksiKeuangan::create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'LAINNYA',
            'nominal'      => 400000,
            'keterangan'   => 'Pengembalian Biaya Listrik',
            'tanggal'      => '2026-05-16',
            'dicatat_oleh' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.keuangan.index', [
            'jenis'  => 'pengeluaran',
            'search' => 'Listrik',
        ]));

        $response->assertOk();
        $transaksi = $response->viewData('transaksi');
        $this->assertCount(1, $transaksi);
        $this->assertEquals('pengeluaran', $transaksi->first()->jenis);
        $this->assertEquals('Listrik Gedung Utama', $transaksi->first()->keterangan);
    }

    public function test_data_transaksi_dibatasi_10_item_per_halaman_pagination(): void
    {
        $admin = $this->buatAdmin();

        for ($i = 1; $i <= 15; $i++) {
            TransaksiKeuangan::create([
                'jenis'        => 'pemasukan',
                'kategori'     => 'DONASI',
                'nominal'      => 100000,
                'keterangan'   => "Transaksi Keuangan Ke-{$i}",
                'tanggal'      => '2026-05-01',
                'dicatat_oleh' => $admin->id,
            ]);
        }

        $response = $this->actingAs($admin)->get(route('admin.keuangan.index'));

        $response->assertOk();
        $data = $response->viewData('transaksi');
        $this->assertCount(10, $data);
        $this->assertEquals(15, $data->total());
    }

    public function test_pencarian_dengan_kata_kunci_tidak_ditemukan_menampilkan_pesan_tidak_ditemukan(): void
    {
        $admin = $this->buatAdmin();

        TransaksiKeuangan::create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 100000,
            'keterangan'   => 'Donasi Hamba Allah',
            'tanggal'      => '2026-05-01',
            'dicatat_oleh' => $admin->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.keuangan.index', ['search' => 'KeywordTidakAda']));

        $response->assertOk();
        $this->assertCount(0, $response->viewData('transaksi'));
        $response->assertSee('Belum ada data transaksi');
        $response->assertSee('Data &quot;KeywordTidakAda&quot; tidak ditemukan', false);
        $response->assertDontSee('Donasi Hamba Allah');
    }
}
