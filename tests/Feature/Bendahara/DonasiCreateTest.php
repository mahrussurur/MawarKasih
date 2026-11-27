<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonasiCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_bendahara_dapat_mengakses_halaman_form_tambah_donasi(): void
    {
        $bendahara = User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);

        $response = $this->actingAs($bendahara)->get(route('bendahara.donasi.create'));

        $response->assertOk();
        $response->assertViewIs('bendahara.donasi.create');
    }

    public function test_guest_dialihkan_ke_halaman_login_saat_mengakses_form_create_donasi(): void
    {
        $response = $this->get(route('bendahara.donasi.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_pengguna_non_bendahara_dilarang_mengakses_form_create_donasi(): void
    {
        $donatur = User::factory()->create(['role' => 'donatur']);

        $response = $this->actingAs($donatur)->get(route('bendahara.donasi.create'));

        $response->assertForbidden();
    }
}
