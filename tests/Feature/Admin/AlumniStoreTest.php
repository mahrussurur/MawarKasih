<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniStoreTest extends TestCase
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

    public function test_admin_berhasil_menyimpan_data_alumni_dan_menghapus_anak_asuh_secara_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = $this->buatDataAnakAsuh(['nama' => 'Budi Santoso']);

        $payload = [
            'tanggal_keluar' => '2026-05-20',
            'pendidikan_terakhir' => 'SMA',
            'nama_sekolah_terakhir' => 'SMK Negeri 1 Banyuwangi',
            'pekerjaan' => 'Karyawan',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Mawar No. 12',
            'catatan' => 'Lulus dengan baik',
        ];

        $response = $this->actingAs($admin)->post(route('alumni.store', $anakAsuh->id), $payload);

        $response->assertRedirect(route('alumni.index'));
        $response->assertSessionHas('success', 'Anak asuh berhasil dijadikan alumni');

        $this->assertDatabaseHas('alumni', [
            'anak_asuh_id' => $anakAsuh->id,
            'nama' => 'Budi Santoso',
            'tanggal_keluar' => '2026-05-20',
            'pekerjaan' => 'Karyawan',
        ]);

        $this->assertSoftDeleted('anak_asuh', [
            'id' => $anakAsuh->id,
        ]);
    }

    public function test_gagal_menyimpan_jika_tanggal_keluar_tidak_diisi(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = $this->buatDataAnakAsuh();

        $response = $this->actingAs($admin)->post(route('alumni.store', $anakAsuh->id), [
            'tanggal_keluar' => '',
            'pendidikan_terakhir' => 'SMA',
        ]);

        $response->assertSessionHasErrors('tanggal_keluar');
        $this->assertDatabaseCount('alumni', 0);
        $this->assertNotSoftDeleted('anak_asuh', [
            'id' => $anakAsuh->id,
        ]);
    }

    public function test_admin_dialihkan_ke_anak_asuh_index_jika_anak_asuh_sudah_menjadi_alumni(): void
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

        $response = $this->actingAs($admin)->post(route('alumni.store', $anakAsuh->id), [
            'tanggal_keluar' => '2026-05-20',
        ]);

        $response->assertRedirect(route('anak-asuh.index'));
        $response->assertSessionHas('error', 'Anak asuh ini sudah menjadi alumni.');
    }

    public function test_mengembalikan_404_jika_anak_asuh_id_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('alumni.store', 99999), [
            'tanggal_keluar' => '2026-05-20',
        ]);

        $response->assertNotFound();
    }

    public function test_guest_yang_belum_login_dialihkan_ke_halaman_login(): void
    {
        $anakAsuh = $this->buatDataAnakAsuh();

        $response = $this->post(route('alumni.store', $anakAsuh->id), [
            'tanggal_keluar' => '2026-05-20',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_pengguna_non_admin_dilarang_mengakses_store_alumni(): void
    {
        $donatur = User::factory()->create(['role' => 'donatur']);
        $anakAsuh = $this->buatDataAnakAsuh();

        $response = $this->actingAs($donatur)->post(route('alumni.store', $anakAsuh->id), [
            'tanggal_keluar' => '2026-05-20',
        ]);

        $response->assertForbidden();
    }
}

