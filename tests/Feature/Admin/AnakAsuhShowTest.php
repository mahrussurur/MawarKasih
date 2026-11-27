<?php
// RIDHO
namespace Tests\Feature\Admin;

use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnakAsuhShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_melihat_halaman_detail_anak_asuh(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create([
            'nama' => 'Ahmad Dahlan',
            'nama_panggilan' => 'Ahmad',
        ]);

        $response = $this->actingAs($admin)->get(route('anak-asuh.show', $anakAsuh->id));

        $response->assertOk();
        $response->assertViewIs('admin.anak_asuh.show');
        $response->assertViewHas('anakAsuh');
        $response->assertSee('Ahmad Dahlan');
        $response->assertSee('Ahmad');
    }

    public function test_mengembalikan_404_jika_id_anak_asuh_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('anak-asuh.show', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_parameter_id_anak_asuh_bukan_angka(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/anak-asuh/abc');

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_anak_asuh_sudah_dihapus_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();
        $anakAsuh->delete();

        $response = $this->actingAs($admin)->get(route('anak-asuh.show', $anakAsuh->id));

        $response->assertNotFound();
    }
}
