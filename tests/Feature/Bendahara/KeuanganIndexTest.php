<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KeuanganIndexTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_dapat_menampilkan_halaman_keuangan_beserta_kalkulasi_saldo(): void
    {
        $bendahara = $this->buatBendahara();

        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 1500000,
            'keterangan'   => 'Pemasukan Donasi',
            'dicatat_oleh' => $bendahara->id,
        ]);
        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'nominal'      => 400000,
            'keterangan'   => 'Bayar Listrik',
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->get(route('bendahara.keuangan.index'));

        $response->assertOk();
        $response->assertViewIs('bendahara.keuangan.index');
        $response->assertViewHasAll(['keuangan', 'totalPemasukan', 'totalPengeluaran', 'saldo']);
        $this->assertEquals(1500000, $response->viewData('totalPemasukan'));
        $this->assertEquals(400000, $response->viewData('totalPengeluaran'));
        $this->assertEquals(1100000, $response->viewData('saldo'));
    }

    public function test_bendahara_dapat_memfilter_transaksi_berdasarkan_jenis(): void
    {
        $bendahara = $this->buatBendahara();

        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'keterangan'   => 'Kas Masuk',
            'dicatat_oleh' => $bendahara->id,
        ]);
        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'KONSUMSI',
            'keterangan'   => 'Belanja Dapur',
            'dicatat_oleh' => $bendahara->id,
        ]);

        $responseMasuk = $this->actingAs($bendahara)->get(route('bendahara.keuangan.index', ['jenis' => 'pemasukan']));
        $responseMasuk->assertOk();
        $responseMasuk->assertSee('Kas Masuk');
        $responseMasuk->assertDontSee('Belanja Dapur');

        $responseKeluar = $this->actingAs($bendahara)->get(route('bendahara.keuangan.index', ['jenis' => 'pengeluaran']));
        $responseKeluar->assertOk();
        $responseKeluar->assertSee('Belanja Dapur');
        $responseKeluar->assertDontSee('Kas Masuk');
    }

    public function test_bendahara_dapat_mencari_transaksi_berdasarkan_keterangan(): void
    {
        $bendahara = $this->buatBendahara();

        TransaksiKeuangan::factory()->create([
            'keterangan'   => 'Beli Buku Pelajaran',
            'dicatat_oleh' => $bendahara->id,
        ]);
        TransaksiKeuangan::factory()->create([
            'keterangan'   => 'Tagihan Internet',
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->get(route('bendahara.keuangan.index', ['search' => 'Buku']));

        $response->assertOk();
        $this->assertCount(1, $response->viewData('keuangan'));
        $response->assertSee('Beli Buku Pelajaran');
        $response->assertDontSee('Tagihan Internet');
    }

    public function test_data_keuangan_dibatasi_10_item_per_halaman_pagination(): void
    {
        $bendahara = $this->buatBendahara();

        TransaksiKeuangan::factory()->count(15)->create([
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->get(route('bendahara.keuangan.index'));

        $response->assertOk();
        $keuangan = $response->viewData('keuangan');
        $this->assertCount(10, $keuangan);
        $this->assertEquals(15, $keuangan->total());
    }
}
