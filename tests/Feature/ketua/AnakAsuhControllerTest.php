<?php

namespace Tests\Feature\Ketua;

use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnakAsuhControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create([
            'role' => 'ketua',
        ]));
    }

    // Membuat data anak asuh untuk pengujian
    protected function buatAnakAsuh()
    {
        return AnakAsuh::create([
            'nama' => 'Diana Eka',
            'nama_panggilan' => 'Diana',
            'tempat_lahir' => 'Banyuwangi',
            'tanggal_lahir' => '2005-05-10',
            'jenis_kelamin' => 'P',
            'status_social_anak' => 'Yatim',
            'sekolah' => 'SMA Negeri 1',
            'kelas' => 'XII',
        ]);
    }

    // Menguji Ketua berhasil melihat daftar anak asuh
    public function test_ketua_berhasil_melihat_daftar_anak_asuh(): void
    {
        $this->buatAnakAsuh();

        $response = $this->get(route('ketua.anak-asuh.index'));

        $response->assertOk();
        $response->assertViewIs('ketua.anak_asuh.index');
        $response->assertViewHas('data');
    }

    // Menguji Ketua berhasil melihat detail anak asuh
    public function test_ketua_berhasil_melihat_detail_anak_asuh(): void
    {
        $anakAsuh = $this->buatAnakAsuh();

        $response = $this->get(route('ketua.anak-asuh.show', $anakAsuh->id));

        $response->assertOk();
        $response->assertViewIs('ketua.anak_asuh.show');
        $response->assertViewHas('anakAsuh');
    }
}
