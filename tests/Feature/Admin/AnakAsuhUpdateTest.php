<?php
// RIDHO
namespace Tests\Feature\Admin;

use App\Models\AnakAsuh;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AnakAsuhUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_berhasil_memperbarui_data_anak_asuh_tanpa_mengganti_foto(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create([
            'foto'    => 'original/anak_asuh/foto_lama.jpg',
            'sekolah' => 'SD Negeri 1 Banyuwangi',
            'kelas'   => '5 SD',
        ]);

        $updateData = AnakAsuh::factory()->make([
            'nama'    => 'Budi Santoso (Updated)',
            'sekolah' => 'SMP Negeri 2 Banyuwangi',
            'kelas'   => '7 SMP',
        ])->toArray();

        $response = $this->actingAs($admin)->put(route('anak-asuh.update', $anakAsuh->id), $updateData);

        $response->assertRedirect(route('anak-asuh.index', ['page' => 1]));
        $response->assertSessionHas('success', 'Data berhasil diupdate');

        $this->assertDatabaseHas('anak_asuh', [
            'id'      => $anakAsuh->id,
            'nama'    => 'Budi Santoso (Updated)',
            'sekolah' => 'SMP Negeri 2 Banyuwangi',
            'kelas'   => '7 SMP',
            'foto'    => 'original/anak_asuh/foto_lama.jpg',
        ]);
    }

    public function test_admin_berhasil_memperbarui_data_anak_asuh_sekaligus_mengganti_foto_baru(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create([
            'foto' => 'original/anak_asuh/foto_lama.jpg',
        ]);

        // Fake service tanpa Mockery untuk menangani pemrosesan gambar
        $fakeImageService = new class extends ImageService {
            public function __construct() {}
            public function uploadAndGenerateWebp(UploadedFile $file, string $folder): string
            {
                return 'original/' . $folder . '/foto_baru.webp';
            }
            public function deleteImage(?string $originalPath): void {}
        };
        $this->app->instance(ImageService::class, $fakeImageService);

        $fotoBaru = UploadedFile::fake()->image('foto_baru.jpg', 400, 400);

        $updateData = array_merge(AnakAsuh::factory()->make()->toArray(), [
            'foto' => $fotoBaru,
        ]);

        $response = $this->actingAs($admin)->put(route('anak-asuh.update', $anakAsuh->id), $updateData);

        $response->assertRedirect(route('anak-asuh.index', ['page' => 1]));
        $response->assertSessionHas('success', 'Data berhasil diupdate');

        $this->assertDatabaseHas('anak_asuh', [
            'id'   => $anakAsuh->id,
            'foto' => 'original/anak_asuh/foto_baru.webp',
        ]);
    }

    public function test_gagal_memperbarui_jika_field_wajib_tidak_diisi(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();

        $response = $this->actingAs($admin)
            ->from(route('anak-asuh.edit', $anakAsuh->id))
            ->put(route('anak-asuh.update', $anakAsuh->id), [
                'nama'          => '',
                'jenis_kelamin' => 'X',
            ]);

        $response->assertRedirect(route('anak-asuh.edit', $anakAsuh->id));
        $response->assertSessionHasErrors(['nama', 'jenis_kelamin']);

        $this->assertEquals($anakAsuh->nama, $anakAsuh->fresh()->nama);
    }

    public function test_gagal_memperbarui_jika_tanggal_lahir_lebih_dari_hari_ini(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();

        $updateData = array_merge(AnakAsuh::factory()->make()->toArray(), [
            'tanggal_lahir' => now()->addDay()->format('Y-m-d'),
        ]);

        $response = $this->actingAs($admin)->put(route('anak-asuh.update', $anakAsuh->id), $updateData);

        $response->assertSessionHasErrors([
            'tanggal_lahir' => 'Tanggal lahir tidak boleh lebih dari tanggal hari ini.',
        ]);

        $this->assertEquals($anakAsuh->tanggal_lahir, $anakAsuh->fresh()->tanggal_lahir);
    }

    public function test_gagal_memperbarui_jika_format_tanggal_lahir_tidak_valid(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();

        $updateData = array_merge(AnakAsuh::factory()->make()->toArray(), [
            'tanggal_lahir' => 'format-tidak-valid',
        ]);

        $response = $this->actingAs($admin)->put(route('anak-asuh.update', $anakAsuh->id), $updateData);

        $response->assertSessionHasErrors('tanggal_lahir');

        $this->assertEquals($anakAsuh->tanggal_lahir, $anakAsuh->fresh()->tanggal_lahir);
    }

    public function test_gagal_memperbarui_jika_jenis_kelamin_tidak_valid(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();

        $updateData = array_merge(AnakAsuh::factory()->make()->toArray(), [
            'jenis_kelamin' => 'Z',
        ]);

        $response = $this->actingAs($admin)->put(route('anak-asuh.update', $anakAsuh->id), $updateData);

        $response->assertSessionHasErrors('jenis_kelamin');

        $this->assertEquals($anakAsuh->jenis_kelamin, $anakAsuh->fresh()->jenis_kelamin);
    }

    public function test_gagal_memperbarui_jika_file_foto_bukan_gambar_atau_melebihi_ukuran_maksimal(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $anakAsuh = AnakAsuh::factory()->create();

        // Bukan gambar
        $payloadBukanGambar = array_merge(AnakAsuh::factory()->make()->toArray(), [
            'foto' => UploadedFile::fake()->create('dokumen.txt', 200, 'text/plain'),
        ]);

        $response = $this->actingAs($admin)->put(route('anak-asuh.update', $anakAsuh->id), $payloadBukanGambar);
        $response->assertSessionHasErrors('foto');

        // Ukuran lebih dari 2048 KB
        $payloadOverSize = array_merge(AnakAsuh::factory()->make()->toArray(), [
            'foto' => UploadedFile::fake()->image('foto_besar.png')->size(3000),
        ]);

        $responseOver = $this->actingAs($admin)->put(route('anak-asuh.update', $anakAsuh->id), $payloadOverSize);
        $responseOver->assertSessionHasErrors('foto');
    }

    public function test_mengembalikan_404_jika_id_anak_asuh_tidak_ditemukan(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $updateData = AnakAsuh::factory()->make()->toArray();

        $response = $this->actingAs($admin)->put(route('anak-asuh.update', 99999), $updateData);

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_parameter_id_anak_asuh_bukan_angka(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $updateData = AnakAsuh::factory()->make()->toArray();

        $response = $this->actingAs($admin)->put('/admin/anak-asuh/abc', $updateData);

        $response->assertNotFound();
    }
}
