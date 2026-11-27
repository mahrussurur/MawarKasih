<?php
// RIDHO
namespace Tests\Feature\Admin;

use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnakAsuhEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_melihat_halaman_edit_anak_asuh(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create(['nama' => 'Ahmad Dahlan']);

        $response = $this->actingAs($admin)->get(route('anak-asuh.edit', $anakAsuh->id));

        $response->assertOk();
        $response->assertViewIs('admin.anak_asuh.edit');
        $response->assertViewHas('anakAsuh');
        $response->assertSee('Ahmad Dahlan');
        $response->assertSee('Edit Profil Anak Asuh');
    }

    public function test_mengembalikan_404_jika_id_anak_asuh_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('anak-asuh.edit', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_parameter_id_anak_asuh_bukan_angka(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/anak-asuh/abc/edit');

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_anak_asuh_sudah_dihapus_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();
        $anakAsuh->delete();

        $response = $this->actingAs($admin)->get(route('anak-asuh.edit', $anakAsuh->id));

        $response->assertNotFound();
    }
}
