<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_mengakses_halaman_form_create_alumni_jika_anak_asuh_belum_menjadi_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create(['nama' => 'Budi Santoso']);

        $response = $this->actingAs($admin)->get(route('alumni.create', $anakAsuh->id));

        $response->assertOk();
        $response->assertViewIs('admin.alumni.create');
        $response->assertViewHas('anakAsuh');
        $response->assertSee('Budi Santoso');
    }

    public function test_mengembalikan_404_jika_anak_asuh_id_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('alumni.create', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_parameter_anak_asuh_id_bukan_angka(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/anak-asuh/abc/jadikan-alumni');

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_anak_asuh_sudah_dihapus_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();
        $anakAsuh->delete(); // Soft delete

        $response = $this->actingAs($admin)->get(route('alumni.create', $anakAsuh->id));

        $response->assertNotFound();
    }
}
