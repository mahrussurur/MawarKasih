<?php
// RIDHO
namespace Tests\Feature\Admin;

use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnakAsuhIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_menampilkan_halaman_daftar_anak_asuh_dengan_view_yang_benar(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        AnakAsuh::factory()->create(['nama' => 'Ahmad Dahlan']);

        $response = $this->actingAs($admin)->get(route('anak-asuh.index'));

        $response->assertOk();
        $response->assertViewIs('admin.anak_asuh.index');
        $response->assertViewHas('data');
        $response->assertViewHas('totalData', 1);
        $response->assertSee('Ahmad Dahlan');
    }

    public function test_admin_dapat_mencari_anak_asuh_berdasarkan_nama(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        AnakAsuh::factory()->create(['nama' => 'Budi Santoso']);
        AnakAsuh::factory()->create(['nama' => 'Siti Aminah']);

        // Cari dengan kata kunci "Budi"
        $response = $this->actingAs($admin)->get(route('anak-asuh.index', ['search' => 'Budi']));

        $response->assertOk();
        $response->assertSee('Budi Santoso');
        $response->assertDontSee('Siti Aminah');
    }

    public function test_admin_dapat_mencari_anak_asuh_berdasarkan_nama_panggilan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        AnakAsuh::factory()->create([
            'nama' => 'Rian Hidayat',
            'nama_panggilan' => 'Ian',
        ]);
        AnakAsuh::factory()->create([
            'nama' => 'Doni Siregar',
            'nama_panggilan' => 'Doni',
        ]);

        $response = $this->actingAs($admin)->get(route('anak-asuh.index', ['search' => 'Ian']));

        $response->assertOk();
        $response->assertSee('Rian Hidayat');
        $response->assertDontSee('Doni Siregar');
    }

    public function test_admin_dapat_mencari_anak_asuh_berdasarkan_nama_ayah_atau_ibu(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        AnakAsuh::factory()->create([
            'nama' => 'Anak Pertama',
            'nama_ayah' => 'Bambang Sudiro',
            'status_social_anak' => 'Dhuafa',
        ]);
        AnakAsuh::factory()->create([
            'nama' => 'Anak Kedua',
            'nama_ibu' => 'Sri Wahyuni',
            'status_social_anak' => 'Dhuafa',
        ]);

        // Cari berdasarkan nama ayah
        $responseAyah = $this->actingAs($admin)->get(route('anak-asuh.index', ['search' => 'Bambang']));
        $responseAyah->assertSee('Anak Pertama');
        $responseAyah->assertDontSee('Anak Kedua');

        // Cari berdasarkan nama ibu
        $responseIbu = $this->actingAs($admin)->get(route('anak-asuh.index', ['search' => 'Sri Wahyuni']));
        $responseIbu->assertSee('Anak Kedua');
        $responseIbu->assertDontSee('Anak Pertama');
    }

    public function test_admin_dapat_mencari_anak_asuh_berdasarkan_sekolah(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        AnakAsuh::factory()->create([
            'nama' => 'Rian Hidayat',
            'sekolah' => 'SMK TI Mawar Kasih',
        ]);
        AnakAsuh::factory()->create([
            'nama' => 'Doni Siregar',
            'sekolah' => 'SMA Negeri 5 Banyuwangi',
        ]);

        $response = $this->actingAs($admin)->get(route('anak-asuh.index', ['search' => 'Mawar Kasih']));

        $response->assertOk();
        $response->assertSee('Rian Hidayat');
        $response->assertDontSee('Doni Siregar');
    }

    public function test_data_anak_asuh_dibatasi_10_item_per_halaman_pagination(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Buat 15 data anak asuh
        for ($i = 1; $i <= 15; $i++) {
            AnakAsuh::factory()->create(['nama' => "Anak Asuh {$i}"]);
        }

        $response = $this->actingAs($admin)->get(route('anak-asuh.index'));

        $response->assertOk();
        $data = $response->viewData('data');
        $this->assertCount(10, $data);
        $this->assertEquals(15, $data->total());
        $this->assertEquals(15, $response->viewData('totalData'));
    }

    public function test_pencarian_dengan_kata_kunci_tidak_ditemukan_menampilkan_pesan_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        AnakAsuh::factory()->create(['nama' => 'Budi Santoso']);

        $response = $this->actingAs($admin)->get(route('anak-asuh.index', ['search' => 'KeywordTidakAda']));

        $response->assertOk();
        $response->assertSee('Belum ada data anak asuh');
        $response->assertSee('Data &quot;KeywordTidakAda&quot; tidak ditemukan', false);
        $response->assertDontSee('Budi Santoso');
    }

    public function test_menampilkan_pesan_kosong_ketika_belum_ada_data_anak_asuh(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('anak-asuh.index'));

        $response->assertOk();
        $response->assertSee('Belum ada data anak asuh');
        $response->assertSee('Tambahkan data anak asuh');
    }
}
