<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_melihat_halaman_detail_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $alumni = Alumni::factory()->create(['nama' => 'Ahmad Dahlan']);

        $response = $this->actingAs($admin)->get(route('alumni.show', $alumni->id));

        $response->assertOk();
        $response->assertViewIs('admin.alumni.show');
        $response->assertViewHas('alumni');
        $response->assertSee('Ahmad Dahlan');
    }

    public function test_mengembalikan_404_jika_id_alumni_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('alumni.show', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_parameter_id_alumni_bukan_angka(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/alumni/abc');

        $response->assertNotFound();
    }
}
