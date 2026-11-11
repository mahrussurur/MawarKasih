<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniUpdateTest extends TestCase
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
            'pekerjaan' => 'Pelajar',
            'no_hp' => '081234567890',
            'alamat' => 'Alamat lama',
            'catatan' => 'Catatan lama',
        ], $attributes));
    }

    public function test_admin_berhasil_memperbarui_data_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $alumni = $this->buatAlumni();

        $updateData = [
            'tanggal_keluar' => '2025-06-30',
            'pendidikan_terakhir' => 'S1',
            'nama_sekolah_terakhir' => 'Universitas Indonesia',
            'pekerjaan' => 'Software Engineer',
            'no_hp' => '089876543210',
            'alamat' => 'Jl. Baru No. 45',
            'catatan' => 'Catatan baru telah diperbarui',
        ];

        $response = $this->actingAs($admin)->put(route('alumni.update', $alumni->id), $updateData);

        $response->assertRedirect(route('alumni.index'));
        $response->assertSessionHas('success', 'Data alumni berhasil diupdate');

        $this->assertDatabaseHas('alumni', [
            'id' => $alumni->id,
            'tanggal_keluar' => '2025-06-30',
            'pendidikan_terakhir' => 'S1',
            'nama_sekolah_terakhir' => 'Universitas Indonesia',
            'pekerjaan' => 'Software Engineer',
            'no_hp' => '089876543210',
            'alamat' => 'Jl. Baru No. 45',
            'catatan' => 'Catatan baru telah diperbarui',
        ]);
    }

    public function test_gagal_memperbarui_jika_tanggal_keluar_kosong(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $alumni = $this->buatAlumni(['tanggal_keluar' => '2023-01-01']);

        $response = $this->actingAs($admin)->put(route('alumni.update', $alumni->id), [
            'tanggal_keluar' => '',
            'pendidikan_terakhir' => 'S1',
        ]);

        $response->assertSessionHasErrors('tanggal_keluar');

        $this->assertDatabaseHas('alumni', [
            'id' => $alumni->id,
            'tanggal_keluar' => '2023-01-01',
        ]);
    }

    public function test_mengembalikan_404_jika_id_alumni_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->put(route('alumni.update', 99999), [
            'tanggal_keluar' => '2025-06-30',
        ]);

        $response->assertNotFound();
    }

    public function test_guest_dialihkan_ke_halaman_login(): void
    {
        $alumni = $this->buatAlumni();

        $response = $this->put(route('alumni.update', $alumni->id), [
            'tanggal_keluar' => '2025-06-30',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_pengguna_non_admin_dilarang_memperbarui_alumni(): void
    {
        $donatur = User::factory()->create(['role' => 'donatur']);
        $alumni = $this->buatAlumni();

        $response = $this->actingAs($donatur)->put(route('alumni.update', $alumni->id), [
            'tanggal_keluar' => '2025-06-30',
        ]);

        $response->assertForbidden();
    }
}

