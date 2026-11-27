<?php
// RIDHO
namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnakAsuhCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_mengakses_halaman_form_create_anak_asuh_dengan_view_yang_benar(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('anak-asuh.create'));

        $response->assertOk();
        $response->assertViewIs('admin.anak_asuh.create');
        $response->assertSee('Tambah Data Anak Asuh');
        $response->assertSee('Nama Lengkap');
        $response->assertSee('Nama Panggilan');
        $response->assertSee('Tempat Lahir');
        $response->assertSee('Tanggal Lahir');
        $response->assertSee('Tinggal di LKSA sejak');
        $response->assertSee('Sekolah');
        $response->assertSee('Kelas');
        $response->assertSee('Jenis Kelamin');
        $response->assertSee('Status Sosial Anak');
    }
}
