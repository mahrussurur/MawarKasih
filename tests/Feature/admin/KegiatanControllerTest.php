<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use App\Models\User;
use App\Services\ImageService;
use App\Http\Controllers\Admin\KegiatanController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Mockery;

class KegiatanControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['role' => 'admin'])
        );
    }

    // Membuat data kegiatan untuk pengujian
    private function buatKegiatan(array $data = []): Kegiatan
    {
        return Kegiatan::create(array_merge([
            'nama_kegiatan' => 'Santunan Anak Yatim',
            'tanggal_pelaksanaan' => '2026-10-20',
            'deskripsi' => '<p>Kegiatan santunan anak yatim.</p>',
            'foto_dokumentasi' => 'original/kegiatan/foto-lama.jpg',
        ], $data));
    }

    // 1. Menguji constructor KegiatanController
    public function test_construct_kegiatan_controller(): void
    {
        $controller = app(KegiatanController::class);

        $this->assertInstanceOf(KegiatanController::class, $controller);
    }

    // 2. Menguji halaman daftar kegiatan
    public function test_index_kegiatan(): void
    {
        $this->buatKegiatan();

        $response = $this->get(route('kegiatan.index', [
            'search' => 'Santunan',
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.kegiatan.index');
        $response->assertViewHas('kegiatans');
    }

    // 3. Menguji halaman tambah kegiatan
    public function test_create_kegiatan(): void
    {
        $response = $this->get(route('kegiatan.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.kegiatan.create');
    }

    // 4. Menguji penyimpanan data kegiatan
    public function test_store_kegiatan(): void
    {
        $imageService = Mockery::mock(ImageService::class);

        $imageService->shouldReceive('uploadAndGenerateWebp')
            ->once()
            ->andReturn('original/kegiatan/foto-test.jpg');

        $this->app->instance(ImageService::class, $imageService);

        $response = $this->post(route('kegiatan.store'), [
            'nama_kegiatan' => 'Santunan Anak Yatim',
            'tanggal_pelaksanaan' => '2026-10-20',
            'deskripsi' => '<p>Kegiatan santunan anak yatim.</p>',
            'foto_dokumentasi' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response->assertRedirect(route('kegiatan.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kegiatans', [
            'nama_kegiatan' => 'Santunan Anak Yatim',
            'tanggal_pelaksanaan' => '2026-10-20',
            'deskripsi' => '<p>Kegiatan santunan anak yatim.</p>',
            'foto_dokumentasi' => 'original/kegiatan/foto-test.jpg',
        ]);
    }

    // 5. Menguji detail kegiatan
    public function test_show_kegiatan(): void
    {
        $kegiatan = $this->buatKegiatan();

        $response = $this->get(route('kegiatan.show', $kegiatan->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.kegiatan.show');
        $response->assertViewHas('kegiatan');
    }

    // 6. Menguji halaman edit kegiatan
    public function test_edit_kegiatan(): void
    {
        $kegiatan = $this->buatKegiatan();

        $response = $this->get(route('kegiatan.edit', $kegiatan->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.kegiatan.edit');
        $response->assertViewHas('kegiatan');
    }

    // 7. Menguji pembaruan data kegiatan
    public function test_update_kegiatan(): void
    {
        $kegiatan = $this->buatKegiatan();

        $imageService = Mockery::mock(ImageService::class);

        $imageService->shouldReceive('deleteImage')
            ->once()
            ->with('original/kegiatan/foto-lama.jpg');

        $imageService->shouldReceive('uploadAndGenerateWebp')
            ->once()
            ->andReturn('original/kegiatan/foto-baru.jpg');

        $this->app->instance(ImageService::class, $imageService);

        $response = $this->put(route('kegiatan.update', $kegiatan->id), [
            'nama_kegiatan' => 'Santunan Anak Yatim Terbaru',
            'tanggal_pelaksanaan' => '2026-10-25',
            'deskripsi' => '<p>Kegiatan telah diperbarui.</p>',
            'foto_dokumentasi' => UploadedFile::fake()->image('foto-baru.jpg'),
        ]);

        $response->assertRedirect(route('kegiatan.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('kegiatans', [
            'id' => $kegiatan->id,
            'nama_kegiatan' => 'Santunan Anak Yatim Terbaru',
            'foto_dokumentasi' => 'original/kegiatan/foto-baru.jpg',
        ]);
    }

    // 8. Menguji penghapusan data kegiatan
    public function test_destroy_kegiatan(): void
    {
        $kegiatan = $this->buatKegiatan();

        $imageService = Mockery::mock(ImageService::class);

        $imageService->shouldReceive('deleteImage')
            ->once()
            ->with('original/kegiatan/foto-lama.jpg');

        $this->app->instance(ImageService::class, $imageService);

        $response = $this->delete(
            route('kegiatan.destroy', $kegiatan->id)
        );

        $response->assertRedirect(route('kegiatan.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('kegiatans', [
            'id' => $kegiatan->id,
        ]);
    }

    // 9. Menguji fungsi sanitizeHtml
    public function test_sanitize_html_kegiatan(): void
    {
        $imageService = Mockery::mock(ImageService::class);

        $controller = new KegiatanController($imageService);

        $method = new \ReflectionMethod(
            KegiatanController::class,
            'sanitizeHtml'
        );

        $method->setAccessible(true);

        $hasil = $method->invoke(
            $controller,
            '<p>Kegiatan <script>alert("test")</script><strong>Santunan</strong></p>'
        );

        $this->assertStringNotContainsString('<script>', $hasil);
        $this->assertStringContainsString('<p>', $hasil);
        $this->assertStringContainsString('<strong>', $hasil);
    }
}
