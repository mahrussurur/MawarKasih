<?php

namespace Tests\Feature\Ketua;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AnakAsuh;

class AlumniControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['role' => 'ketua'])
        );
    }

    protected function buatAlumni()
    {
        // Membuat data anak asuh terlebih dahulu
        $anakAsuh = AnakAsuh::create([
            'nama' => 'Diana Eka',
            'tempat_lahir' => 'Banyuwangi',
            'tanggal_lahir' => '2005-05-10',
            'jenis_kelamin' => 'P',
            'status_social_anak' => 'Yatim',
            'sekolah' => 'SMA Negeri 1',
            'kelas' => 'XII',
        ]);

        // Membuat data alumni berdasarkan anak asuh
        return Alumni::create([
            'anak_asuh_id' => $anakAsuh->id,
            'nama' => 'Diana Eka',
            'tempat_lahir' => 'Banyuwangi',
            'tanggal_lahir' => '2005-05-10',
            'jenis_kelamin' => 'P',
            'status_social_anak' => 'Yatim',
            'sekolah' => 'SMA Negeri 1',
            'kelas' => 'XII',
            'tanggal_keluar' => '2025-06-30',
            'pendidikan_terakhir' => 'SMA',
            'nama_sekolah_terakhir' => 'SMA Negeri 1',
        ]);
    }
    // 1. Menguji Ketua berhasil melihat daftar alumni
    public function test_ketua_berhasil_melihat_daftar_alumni(): void
    {
        $this->buatAlumni();

        $response = $this->get(route('ketua.alumni.index'));

        $response->assertOk();
        $response->assertViewIs('ketua.alumni.index');
        $response->assertViewHas('data');
    }

    // 2. Menguji Ketua berhasil melihat detail alumni
    public function test_ketua_berhasil_melihat_detail_alumni(): void
    {
        $alumni = $this->buatAlumni();

        $response = $this->get(
            route('ketua.alumni.show', $alumni->id)
        );

        $response->assertOk();
        $response->assertViewIs('ketua.alumni.show');
        $response->assertViewHas('alumni');
    }
}
