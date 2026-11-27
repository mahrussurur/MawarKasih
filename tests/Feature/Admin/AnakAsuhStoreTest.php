<?php
// RIDHO
namespace Tests\Feature\Admin;

use App\Models\AnakAsuh;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery;
use Tests\TestCase;

class AnakAsuhStoreTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'nama'                  => 'Budi Setiawan',
            'nama_panggilan'        => 'Budi',
            'tempat_lahir'          => 'Banyuwangi',
            'tanggal_lahir'         => '2015-05-10',
            'jenis_kelamin'         => 'L',
            'status_social_anak'    => 'Dhuafa',
            'nama_ayah'             => 'Hendra Setiawan',
            'nama_ibu'              => 'Siti Aminah',
            'tinggal_di_lksa_sejak' => '2020',
            'sekolah'               => 'SD Negeri 1 Banyuwangi',
            'kelas'                 => '4 SD',
        ], $overrides);
    }

    public function test_admin_berhasil_menyimpan_data_anak_asuh_tanpa_foto(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = $this->validPayload();

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), $payload);

        $response->assertRedirect(route('anak-asuh.index'));
        $response->assertSessionHas('success', 'Data berhasil ditambahkan');

        $this->assertDatabaseHas('anak_asuh', [
            'nama'                  => 'Budi Setiawan',
            'nama_panggilan'        => 'Budi',
            'tempat_lahir'          => 'Banyuwangi',
            'tanggal_lahir'         => '2015-05-10',
            'jenis_kelamin'         => 'L',
            'status_social_anak'    => 'Dhuafa',
            'nama_ayah'             => 'Hendra Setiawan',
            'nama_ibu'              => 'Siti Aminah',
            'tinggal_di_lksa_sejak' => '2020',
            'sekolah'               => 'SD Negeri 1 Banyuwangi',
            'kelas'                 => '4 SD',
            'foto'                  => null,
        ]);
    }

    public function test_admin_berhasil_menyimpan_data_anak_asuh_dengan_foto(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $mockImageService = Mockery::mock(ImageService::class);
        $mockImageService->shouldReceive('uploadAndGenerateWebp')
            ->once()
            ->andReturn('original/anak_asuh/foto_anak_baru.webp');
        $this->app->instance(ImageService::class, $mockImageService);

        $payload = $this->validPayload([
            'foto' => UploadedFile::fake()->image('anak.jpg', 600, 600),
        ]);

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), $payload);

        $response->assertRedirect(route('anak-asuh.index'));
        $response->assertSessionHas('success', 'Data berhasil ditambahkan');

        $this->assertDatabaseHas('anak_asuh', [
            'nama' => 'Budi Setiawan',
            'foto' => 'original/anak_asuh/foto_anak_baru.webp',
        ]);
    }

    public function test_admin_dapat_menyimpan_data_anak_asuh_meskipun_field_opsional_nama_ayah_dan_ibu_tidak_diisi(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = $this->validPayload([
            'nama_ayah' => null,
            'nama_ibu'  => null,
        ]);

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), $payload);

        $response->assertRedirect(route('anak-asuh.index'));
        $this->assertDatabaseHas('anak_asuh', [
            'nama'      => 'Budi Setiawan',
            'nama_ayah' => null,
            'nama_ibu'  => null,
        ]);
    }

    public function test_otomatis_mengosongkan_nama_ayah_jika_status_sosial_yatim(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = $this->validPayload([
            'status_social_anak' => 'Yatim',
            'nama_ayah'          => 'Alm. Hendra',
            'nama_ibu'           => 'Siti Aminah',
        ]);

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), $payload);

        $response->assertRedirect(route('anak-asuh.index'));
        $this->assertDatabaseHas('anak_asuh', [
            'nama'               => 'Budi Setiawan',
            'status_social_anak' => 'Yatim',
            'nama_ayah'          => null,
            'nama_ibu'           => 'Siti Aminah',
        ]);
    }

    public function test_otomatis_mengosongkan_nama_ibu_jika_status_sosial_piatu(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = $this->validPayload([
            'status_social_anak' => 'Piatu',
            'nama_ayah'          => 'Hendra Setiawan',
            'nama_ibu'           => 'Almh. Siti',
        ]);

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), $payload);

        $response->assertRedirect(route('anak-asuh.index'));
        $this->assertDatabaseHas('anak_asuh', [
            'nama'               => 'Budi Setiawan',
            'status_social_anak' => 'Piatu',
            'nama_ayah'          => 'Hendra Setiawan',
            'nama_ibu'           => null,
        ]);
    }

    public function test_otomatis_mengosongkan_nama_ayah_dan_nama_ibu_jika_status_sosial_yatim_piatu(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = $this->validPayload([
            'status_social_anak' => 'Yatim Piatu',
            'nama_ayah'          => 'Alm. Hendra',
            'nama_ibu'           => 'Almh. Siti',
        ]);

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), $payload);

        $response->assertRedirect(route('anak-asuh.index'));
        $this->assertDatabaseHas('anak_asuh', [
            'nama'               => 'Budi Setiawan',
            'status_social_anak' => 'Yatim Piatu',
            'nama_ayah'          => null,
            'nama_ibu'           => null,
        ]);
    }

    public function test_gagal_menyimpan_jika_field_wajib_tidak_diisi(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), []);

        $response->assertSessionHasErrors([
            'nama',
            'nama_panggilan',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'status_social_anak',
            'tinggal_di_lksa_sejak',
            'sekolah',
            'kelas',
        ]);
        $this->assertDatabaseCount('anak_asuh', 0);
    }

    public function test_gagal_menyimpan_jika_tanggal_lahir_lebih_dari_hari_ini(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = $this->validPayload([
            'tanggal_lahir' => now()->addDay()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), $payload);

        $response->assertSessionHasErrors([
            'tanggal_lahir' => 'Tanggal lahir tidak boleh lebih dari tanggal hari ini.',
        ]);
        $this->assertDatabaseCount('anak_asuh', 0);
    }

    public function test_gagal_menyimpan_jika_format_tanggal_lahir_tidak_valid(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = $this->validPayload([
            'tanggal_lahir' => 'bukan-format-tanggal',
        ]);

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), $payload);

        $response->assertSessionHasErrors('tanggal_lahir');
        $this->assertDatabaseCount('anak_asuh', 0);
    }

    public function test_gagal_menyimpan_jika_jenis_kelamin_tidak_valid(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = $this->validPayload([
            'jenis_kelamin' => 'X',
        ]);

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), $payload);

        $response->assertSessionHasErrors('jenis_kelamin');
        $this->assertDatabaseCount('anak_asuh', 0);
    }

    public function test_gagal_menyimpan_jika_file_foto_bukan_gambar_atau_melebihi_ukuran_maksimal(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Uji coba file dokumen bukan gambar
        $payloadNonImage = $this->validPayload([
            'foto' => UploadedFile::fake()->create('dokumen.pdf', 500, 'application/pdf'),
        ]);

        $response = $this->actingAs($admin)->post(route('anak-asuh.store'), $payloadNonImage);
        $response->assertSessionHasErrors('foto');

        // Uji coba ukuran gambar melebihi 2048 KB (2MB)
        $payloadOverSize = $this->validPayload([
            'foto' => UploadedFile::fake()->image('gambar_besar.jpg')->size(3000),
        ]);

        $responseOver = $this->actingAs($admin)->post(route('anak-asuh.store'), $payloadOverSize);
        $responseOver->assertSessionHasErrors('foto');

        $this->assertDatabaseCount('anak_asuh', 0);
    }
}
