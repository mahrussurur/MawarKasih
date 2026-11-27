<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KeuanganCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_bendahara_dapat_mengakses_halaman_form_tambah_transaksi_keuangan(): void
    {
        $bendahara = User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);

        $response = $this->actingAs($bendahara)->get(route('bendahara.keuangan.create'));

        $response->assertOk();
        $response->assertViewIs('bendahara.keuangan.create');
    }

    public function test_guest_dialihkan_ke_halaman_login_saat_mengakses_form_create_keuangan(): void
    {
        $response = $this->get(route('bendahara.keuangan.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_pengguna_non_bendahara_dilarang_mengakses_form_create_keuangan(): void
    {
        $donatur = User::factory()->create(['role' => 'donatur']);

        $response = $this->actingAs($donatur)->get(route('bendahara.keuangan.create'));

        $response->assertForbidden();
    }
}
