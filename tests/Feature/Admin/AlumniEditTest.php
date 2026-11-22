<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_melihat_halaman_edit_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $alumni = Alumni::factory()->create(['nama' => 'Ahmad Dahlan']);

        $response = $this->actingAs($admin)->get(route('alumni.edit', $alumni->id));

        $response->assertOk();
        $response->assertViewIs('admin.alumni.edit');
        $response->assertViewHas('alumni');
        $response->assertSee('Ahmad Dahlan');
    }

    public function test_mengembalikan_404_jika_id_alumni_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('alumni.edit', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_parameter_id_alumni_bukan_angka(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/alumni/abc/edit');

        $response->assertNotFound();
    }
}
