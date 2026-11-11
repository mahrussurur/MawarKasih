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

    private function buatDataAnakAsuh(array $attributes = []): AnakAsuh
    {
        return AnakAsuh::create(array_merge([
            'nama' => 'Budi Santoso',
            'tempat_lahir' => 'Banyuwangi',
            'tanggal_lahir' => '2010-05-15',
            'jenis_kelamin' => 'L',
            'status_social_anak' => 'Yatim',
        ], $attributes));
    }

    public function test_admin_dapat_mengakses_halaman_form_create_alumni_jika_anak_asuh_belum_menjadi_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = $this->buatDataAnakAsuh(['nama' => 'Budi Santoso']);

        $response = $this->actingAs($admin)->get(route('alumni.create', $anakAsuh->id));

        $response->assertOk();
        $response->assertViewIs('admin.alumni.create');
        $response->assertViewHas('anakAsuh');
        $response->assertSee('Budi Santoso');
    }

    public function test_admin_dialihkan_kembali_ke_anak_asuh_index_jika_anak_asuh_sudah_pernah_menjadi_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = $this->buatDataAnakAsuh();

        Alumni::create([
            'anak_asuh_id' => $anakAsuh->id,
            'nama' => $anakAsuh->nama,
            'tempat_lahir' => $anakAsuh->tempat_lahir,
            'tanggal_lahir' => $anakAsuh->tanggal_lahir,
            'jenis_kelamin' => $anakAsuh->jenis_kelamin,
            'status_social_anak' => $anakAsuh->status_social_anak,
            'tanggal_keluar' => '2025-01-01',
            'pendidikan_terakhir' => 'SMA',
            'nama_sekolah_terakhir' => 'SMK Negeri 1',
        ]);

        $response = $this->actingAs($admin)->get(route('alumni.create', $anakAsuh->id));

        $response->assertRedirect(route('anak-asuh.index'));
        $response->assertSessionHas('error', 'Anak asuh ini sudah menjadi alumni.');
    }

    public function test_mengembalikan_404_jika_anak_asuh_id_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('alumni.create', 99999));

        $response->assertNotFound();
    }

    public function test_guest_yang_belum_login_dialihkan_ke_halaman_login(): void
    {
        $anakAsuh = $this->buatDataAnakAsuh();

        $response = $this->get(route('alumni.create', $anakAsuh->id));

        $response->assertRedirect(route('login'));
    }

    public function test_pengguna_non_admin_dilarang_mengakses_form_create_alumni(): void
    {
        $donatur = User::factory()->create(['role' => 'donatur']);
        $anakAsuh = $this->buatDataAnakAsuh();

        $response = $this->actingAs($donatur)->get(route('alumni.create', $anakAsuh->id));

        $response->assertForbidden();
    }
}
