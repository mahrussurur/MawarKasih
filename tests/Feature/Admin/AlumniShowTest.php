<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniShowTest extends TestCase
{
    use RefreshDatabase;

    private function buatAlumni(array $attributes = []): Alumni
    {
        $anak = AnakAsuh::create([
            'nama' => 'Anak ' . uniqid(),
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2010-01-01',
            'jenis_kelamin' => 'L',
            'status_social_anak' => 'Yatim',
        ]);

        return Alumni::create(array_merge([
            'anak_asuh_id' => $anak->id,
            'nama' => 'Budi Santoso',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2000-01-01',
            'jenis_kelamin' => 'L',
            'status_social_anak' => 'Yatim',
            'tanggal_keluar' => '2023-01-01',
            'pendidikan_terakhir' => 'SMA',
            'nama_sekolah_terakhir' => 'SMK Negeri 1',
        ], $attributes));
    }

    public function test_admin_dapat_melihat_halaman_detail_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $alumni = $this->buatAlumni(['nama' => 'Ahmad Dahlan']);

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

    public function test_guest_dialihkan_ke_halaman_login(): void
    {
        $alumni = $this->buatAlumni();

        $response = $this->get(route('alumni.show', $alumni->id));

        $response->assertRedirect(route('login'));
    }

    public function test_pengguna_non_admin_dilarang_mengakses_detail_alumni(): void
    {
        $donatur = User::factory()->create(['role' => 'donatur']);
        $alumni = $this->buatAlumni();

        $response = $this->actingAs($donatur)->get(route('alumni.show', $alumni->id));

        $response->assertForbidden();
    }
}

