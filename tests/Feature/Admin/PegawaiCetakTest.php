<?php

namespace Tests\Feature\Admin;

use App\Models\ProfilPegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PegawaiCetakTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_mencetak_laporan_data_pegawai(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pegawaiUser = User::factory()->create(['role' => 'bendahara']);

        ProfilPegawai::create([
            'user_id'       => $pegawaiUser->id,
            'nama'          => 'Siti Aminah',
            'tempat_lahir'  => 'Banyuwangi',
            'tanggal_lahir' => '1990-05-15',
            'jabatan'       => 'Bendahara',
            'jenis_kelamin' => 'P',
            'no_hp'         => '081234567890',
            'alamat'        => 'Jl. Mawar No. 10',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.pegawai.cetak'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString(
            'Laporan_Data_Pegawai_Mawar_Kasih.pdf',
            (string) $response->headers->get('Content-Disposition')
        );
    }

    public function test_admin_tidak_dapat_mencetak_jika_belum_ada_data_pegawai(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->from(route('admin.pegawai.index'))
            ->actingAs($admin)
            ->get(route('admin.pegawai.cetak'));

        $response->assertRedirect(route('admin.pegawai.index'));
        $response->assertSessionHas('error');
    }

    public function test_guest_dialihkan_ke_halaman_login_saat_mengakses_cetak_pegawai(): void
    {
        $response = $this->get(route('admin.pegawai.cetak'));

        $response->assertRedirect(route('login'));
    }

    public function test_pengguna_non_admin_dilarang_mengakses_cetak_pegawai(): void
    {
        $donatur = User::factory()->create(['role' => 'donatur']);

        $response = $this->actingAs($donatur)->get(route('admin.pegawai.cetak'));

        $response->assertForbidden();
    }
}
