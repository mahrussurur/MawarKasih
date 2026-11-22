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

    public function test_admin_berhasil_menyimpan_data_alumni_dan_menghapus_anak_asuh_secara_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create(['nama' => 'Budi Santoso']);

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

    public function test_admin_dapat_menyimpan_data_alumni_meskipun_field_opsional_tidak_diisi(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create(['nama' => 'Siti Nurhaliza']);

        $payload = [
            'tanggal_keluar' => '2026-05-20',
            'pendidikan_terakhir' => null,
            'nama_sekolah_terakhir' => null,
            'pekerjaan' => null,
            'no_hp' => null,
            'alamat' => null,
            'catatan' => null,
        ];

        $response = $this->actingAs($admin)->post(route('alumni.store', $anakAsuh->id), $payload);

        $response->assertRedirect(route('alumni.index'));
        $this->assertDatabaseHas('alumni', [
            'anak_asuh_id' => $anakAsuh->id,
            'nama' => 'Siti Nurhaliza',
            'tanggal_keluar' => '2026-05-20',
            'pendidikan_terakhir' => null,
        ]);
    }

    public function test_gagal_menyimpan_jika_tanggal_keluar_tidak_diisi(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();

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

    public function test_gagal_menyimpan_jika_format_tanggal_keluar_tidak_valid(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();

        $response = $this->actingAs($admin)->post(route('alumni.store', $anakAsuh->id), [
            'tanggal_keluar' => 'bukan-tanggal-valid',
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
        $anakAsuh = AnakAsuh::factory()->create();

        Alumni::factory()->create([
            'anak_asuh_id' => $anakAsuh->id,
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

    public function test_mengembalikan_404_jika_parameter_anak_asuh_id_bukan_angka(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/anak-asuh/abc/jadikan-alumni', [
            'tanggal_keluar' => '2026-05-20',
        ]);

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_anak_asuh_sudah_dihapus_soft_delete(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();
        $anakAsuh->delete(); // Soft delete

        $response = $this->actingAs($admin)->post(route('alumni.store', $anakAsuh->id), [
            'tanggal_keluar' => '2026-05-20',
        ]);

        $response->assertNotFound();
    }
}
