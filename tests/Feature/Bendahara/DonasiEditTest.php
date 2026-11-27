<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonasiEditTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_dapat_melihat_halaman_edit_donasi(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create(['nama_donatur' => 'Donatur Edit']);

        $response = $this->actingAs($bendahara)->get(route('bendahara.donasi.edit', $donasi->id));

        $response->assertOk();
        $response->assertViewIs('bendahara.donasi.edit');
        $response->assertViewHas('donasi');
        $response->assertSee('Donatur Edit');
    }

    public function test_mengembalikan_404_jika_id_donasi_tidak_ditemukan(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->get(route('bendahara.donasi.edit', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_parameter_id_donasi_bukan_angka(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->get('/bendahara/donasi/abc/edit');

        $response->assertNotFound();
    }
}
