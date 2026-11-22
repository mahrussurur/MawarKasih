<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_menampilkan_halaman_daftar_alumni_dengan_view_yang_benar(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Alumni::factory()->create(['nama' => 'Ahmad Dahlan']);

        $response = $this->actingAs($admin)->get(route('alumni.index'));

        $response->assertOk();
        $response->assertViewIs('admin.alumni.index');
        $response->assertViewHas('data');
        $response->assertSee('Ahmad Dahlan');
    }

    public function test_admin_dapat_mencari_alumni_berdasarkan_nama(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Alumni::factory()->create(['nama' => 'Budi Santoso']);
        Alumni::factory()->create(['nama' => 'Siti Aminah']);

        // Cari dengan kata kunci "Budi"
        $response = $this->actingAs($admin)->get(route('alumni.index', ['search' => 'Budi']));

        $response->assertOk();
        $response->assertSee('Budi Santoso');
        $response->assertDontSee('Siti Aminah');
    }

    public function test_admin_dapat_mencari_alumni_berdasarkan_nama_sekolah_atau_pendidikan_terakhir(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Alumni::factory()->create([
            'nama' => 'Rian Hidayat',
            'nama_sekolah_terakhir' => 'SMK TI Mawar Kasih',
            'pendidikan_terakhir' => 'SMK',
        ]);
        Alumni::factory()->create([
            'nama' => 'Doni Siregar',
            'nama_sekolah_terakhir' => 'SMA Negeri 5',
            'pendidikan_terakhir' => 'SMA',
        ]);

        // Cari dengan nama sekolah
        $response = $this->actingAs($admin)->get(route('alumni.index', ['search' => 'Mawar Kasih']));
        $response->assertSee('Rian Hidayat');
        $response->assertDontSee('Doni Siregar');

        // Cari dengan pendidikan terakhir
        $response = $this->actingAs($admin)->get(route('alumni.index', ['search' => 'SMK']));
        $response->assertSee('Rian Hidayat');
        $response->assertDontSee('Doni Siregar');
    }

    public function test_data_alumni_dibatasi_10_item_per_halaman_pagination(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Buat 15 alumni
        for ($i = 1; $i <= 15; $i++) {
            Alumni::factory()->create(['nama' => "Alumni {$i}"]);
        }

        $response = $this->actingAs($admin)->get(route('alumni.index'));

        $response->assertOk();
        $data = $response->viewData('data');
        $this->assertCount(10, $data);
        $this->assertEquals(15, $data->total());
    }

    public function test_pencarian_dengan_kata_kunci_tidak_ditemukan_menampilkan_pesan_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Alumni::factory()->create(['nama' => 'Budi Santoso']);

        $response = $this->actingAs($admin)->get(route('alumni.index', ['search' => 'KeywordTidakAda']));

        $response->assertOk();
        $response->assertSee('Belum ada data alumni');
        $response->assertSee('Data &quot;KeywordTidakAda&quot; tidak ditemukan', false);
        $response->assertDontSee('Budi Santoso');
    }
}
