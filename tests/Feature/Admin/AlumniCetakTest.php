<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniCetakTest extends TestCase
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

    public function test_admin_dapat_mencetak_laporan_data_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->buatAlumni(['nama' => 'Ahmad Dahlan']);

        $response = $this->actingAs($admin)->get(route('alumni.cetak'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString('Laporan_Data_Alumni_Mawar_Kasih.pdf', (string) $response->headers->get('Content-Disposition'));
    }

    public function test_admin_dapat_mencetak_meskipun_belum_ada_data_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('alumni.cetak'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_guest_dialihkan_ke_halaman_login(): void
    {
        $response = $this->get(route('alumni.cetak'));

        $response->assertRedirect(route('login'));
    }

    public function test_pengguna_non_admin_dilarang_mengakses_cetak_alumni(): void
    {
        $donatur = User::factory()->create(['role' => 'donatur']);

        $response = $this->actingAs($donatur)->get(route('alumni.cetak'));

        $response->assertForbidden();
    }
}

