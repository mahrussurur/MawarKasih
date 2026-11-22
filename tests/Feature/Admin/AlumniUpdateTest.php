<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_berhasil_memperbarui_data_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $alumni = Alumni::factory()->create();

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
        $alumni = Alumni::factory()->create(['tanggal_keluar' => '2023-01-01']);

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

    public function test_gagal_memperbarui_jika_format_tanggal_keluar_tidak_valid(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $alumni = Alumni::factory()->create(['tanggal_keluar' => '2023-01-01']);

        $response = $this->actingAs($admin)->put(route('alumni.update', $alumni->id), [
            'tanggal_keluar' => 'format-salah',
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

    public function test_mengembalikan_404_jika_parameter_id_alumni_bukan_angka(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->put('/admin/alumni/abc', [
            'tanggal_keluar' => '2025-06-30',
        ]);

        $response->assertNotFound();
    }
}
