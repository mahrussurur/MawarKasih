<?php

namespace Tests\Feature;

use App\Models\Galeri;
use App\Models\User;
use App\Services\ImageService;
use App\Http\Controllers\Admin\GaleriController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Mockery;

class GaleriControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['role' => 'admin'])
        );
    }

    // Membuat data galeri untuk pengujian
    private function buatGaleri(array $data = []): Galeri
    {
        return Galeri::create(array_merge([
            'judul' => 'Kegiatan Santunan',
            'deskripsi' => 'Kegiatan santunan anak yatim.',
            'kategori' => 'Umum',
            'foto' => 'original/galeri/foto-lama.jpg',
        ], $data));
    }

    // 1. Menguji constructor GaleriController
    public function test_construct_galeri_controller(): void
    {
        $controller = app(GaleriController::class);

        $this->assertInstanceOf(GaleriController::class, $controller);
    }

    // 2. Menguji halaman daftar galeri
    public function test_index_galeri(): void
    {
        $this->buatGaleri();

        $response = $this->get(route('galeri.index', [
            'kategori' => 'Umum',
            'search' => 'Santunan',
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.galeri.index');
        $response->assertViewHas('galeris');
        $response->assertViewHas('totalGaleri', 1);
    }

    // 3. Menguji halaman tambah galeri
    public function test_create_galeri(): void
    {
        $response = $this->get(route('galeri.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.galeri.create');
    }

    // 4. Menguji penyimpanan data galeri
    public function test_store_galeri(): void
    {
        $imageService = Mockery::mock(ImageService::class);

        $imageService->shouldReceive('uploadAndGenerateWebp')
            ->once()
            ->andReturn('original/galeri/foto-test.jpg');

        $this->app->instance(ImageService::class, $imageService);

        $response = $this->post(route('galeri.store'), [
            'judul' => 'Kegiatan Santunan',
            'deskripsi' => 'Kegiatan santunan anak yatim.',
            'kategori' => 'Umum',
            'foto' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response->assertRedirect(route('galeri.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('galeris', [
            'judul' => 'Kegiatan Santunan',
            'deskripsi' => 'Kegiatan santunan anak yatim.',
            'kategori' => 'Umum',
            'foto' => 'original/galeri/foto-test.jpg',
        ]);
    }

    // 5. Menguji detail data galeri
    public function test_show_galeri(): void
    {
        $galeri = $this->buatGaleri();

        $response = $this->get(route('galeri.show', $galeri->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.galeri.show');
        $response->assertViewHas('galeri');
    }

    // 6. Menguji halaman edit galeri
    public function test_edit_galeri(): void
    {
        $galeri = $this->buatGaleri();

        $response = $this->get(route('galeri.edit', $galeri->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.galeri.edit');
        $response->assertViewHas('galeri');
    }

    // 7. Menguji pembaruan data galeri
    public function test_update_galeri(): void
    {
        $galeri = $this->buatGaleri();

        $imageService = Mockery::mock(ImageService::class);

        $imageService->shouldReceive('deleteImage')
            ->once()
            ->with('original/galeri/foto-lama.jpg');

        $imageService->shouldReceive('uploadAndGenerateWebp')
            ->once()
            ->andReturn('original/galeri/foto-baru.jpg');

        $this->app->instance(ImageService::class, $imageService);

        $response = $this->put(route('galeri.update', $galeri->id), [
            'judul' => 'Kegiatan Santunan Terbaru',
            'deskripsi' => 'Deskripsi kegiatan telah diperbarui.',
            'kategori' => 'Umum',
            'foto' => UploadedFile::fake()->image('foto-baru.jpg'),
        ]);

        $response->assertRedirect(route('galeri.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('galeris', [
            'id' => $galeri->id,
            'judul' => 'Kegiatan Santunan Terbaru',
            'foto' => 'original/galeri/foto-baru.jpg',
        ]);
    }

    // 8. Menguji penghapusan data galeri
    public function test_destroy_galeri(): void
    {
        $galeri = $this->buatGaleri();

        $imageService = Mockery::mock(ImageService::class);

        $imageService->shouldReceive('deleteImage')
            ->once()
            ->with('original/galeri/foto-lama.jpg');

        $this->app->instance(ImageService::class, $imageService);

        $response = $this->delete(route('galeri.destroy', $galeri->id));

        $response->assertRedirect(route('galeri.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('galeris', [
            'id' => $galeri->id,
        ]);
    }
}
