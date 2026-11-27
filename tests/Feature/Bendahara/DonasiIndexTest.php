<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonasiIndexTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_dapat_menampilkan_halaman_daftar_donasi_beserta_ringkasan_statistik(): void
    {
        $bendahara = $this->buatBendahara();
        $donaturTetap = User::factory()->create(['role' => 'donatur']);

        Donasi::factory()->create(['status' => 'pending', 'nominal' => 100000]);
        Donasi::factory()->create([
            'status'     => 'diterima',
            'nominal'    => 500000,
            'donatur_id' => $donaturTetap->id,
        ]);
        Donasi::factory()->create([
            'status'     => 'diterima',
            'nominal'    => 250000,
            'donatur_id' => null,
        ]);
        Donasi::factory()->create(['status' => 'ditolak', 'nominal' => 50000]);

        $response = $this->actingAs($bendahara)->get(route('bendahara.donasi.index'));

        $response->assertOk();
        $response->assertViewIs('bendahara.donasi.index');
        $response->assertViewHasAll([
            'donasi',
            'totalDonasi',
            'totalPending',
            'totalValid',
            'totalDitolak',
            'totalNominal',
            'nominalDonaturTetap',
            'nominalDonaturUmum',
        ]);

        $this->assertSame(4, $response->viewData('totalDonasi'));
        $this->assertSame(1, $response->viewData('totalPending'));
        $this->assertSame(2, $response->viewData('totalValid'));
        $this->assertSame(1, $response->viewData('totalDitolak'));
        $this->assertEquals(750000, $response->viewData('totalNominal'));
        $this->assertEquals(500000, $response->viewData('nominalDonaturTetap'));
        $this->assertEquals(250000, $response->viewData('nominalDonaturUmum'));
    }

    public function test_bendahara_dapat_memfilter_donasi_berdasarkan_status(): void
    {
        $bendahara = $this->buatBendahara();

        Donasi::factory()->create(['nama_donatur' => 'Donatur Pending', 'status' => 'pending']);
        Donasi::factory()->create(['nama_donatur' => 'Donatur Diterima', 'status' => 'diterima']);

        $response = $this->actingAs($bendahara)->get(route('bendahara.donasi.index', ['status' => 'pending']));

        $response->assertOk();
        $this->assertCount(1, $response->viewData('donasi'));
        $response->assertSee('Donatur Pending');
        $response->assertDontSee('Donatur Diterima');
    }

    public function test_bendahara_dapat_mencari_donasi_berdasarkan_nama_donatur_atau_kode_donasi(): void
    {
        $bendahara = $this->buatBendahara();

        Donasi::factory()->create(['nama_donatur' => 'Budi Santoso', 'kode_donasi' => 'DON-CARI01']);
        Donasi::factory()->create(['nama_donatur' => 'Siti Aminah', 'kode_donasi' => 'DON-LAIN02']);

        $responseNama = $this->actingAs($bendahara)->get(route('bendahara.donasi.index', ['search' => 'Budi']));
        $responseNama->assertOk();
        $responseNama->assertSee('Budi Santoso');
        $responseNama->assertDontSee('Siti Aminah');

        $responseKode = $this->actingAs($bendahara)->get(route('bendahara.donasi.index', ['search' => 'DON-LAIN02']));
        $responseKode->assertOk();
        $responseKode->assertSee('Siti Aminah');
        $responseKode->assertDontSee('Budi Santoso');
    }

    public function test_data_donasi_dibatasi_10_item_per_halaman_pagination(): void
    {
        $bendahara = $this->buatBendahara();

        Donasi::factory()->count(15)->create();

        $response = $this->actingAs($bendahara)->get(route('bendahara.donasi.index'));

        $response->assertOk();
        $donasi = $response->viewData('donasi');
        $this->assertCount(10, $donasi);
        $this->assertEquals(15, $donasi->total());
    }
}
