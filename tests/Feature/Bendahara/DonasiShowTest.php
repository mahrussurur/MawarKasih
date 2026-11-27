<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonasiShowTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_dapat_melihat_halaman_detail_donasi(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create([
            'nama_donatur' => 'Ahmad Dermawan',
            'kode_donasi'  => 'DON-SHOW01',
        ]);

        $response = $this->actingAs($bendahara)->get(route('bendahara.donasi.show', $donasi->id));

        $response->assertOk();
        $response->assertViewIs('bendahara.donasi.show');
        $response->assertViewHas('donasi');
        $response->assertSee('DON-SHOW01');
        $response->assertSee('Ahmad Dermawan');
    }

    public function test_mengembalikan_404_jika_id_donasi_tidak_ditemukan(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->get(route('bendahara.donasi.show', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_parameter_id_donasi_bukan_angka(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->get('/bendahara/donasi/abc');

        $response->assertNotFound();
    }
}
