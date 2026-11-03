<?php

namespace Tests\Unit\Admin;

use App\Http\Controllers\Admin\AnakAsuhController;
use App\Models\AnakAsuh;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Mockery;
use Tests\TestCase;

class AnakAsuhUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper untuk membuat data awal Anak Asuh.
     */
    private function buatDummyAnakAsuh(array $attributes = []): AnakAsuh
    {
        return AnakAsuh::create(array_merge([
            'nama'                  => 'Budi Setiawan',
            'nama_panggilan'        => 'Budi',
            'tempat_lahir'          => 'Bandung',
            'tanggal_lahir'         => '2012-05-10',
            'jenis_kelamin'         => 'L',
            'status_social_anak'    => 'Yatim',
            'tinggal_di_lksa_sejak' => '2020',
            'sekolah'               => 'SD Negeri 1',
            'kelas'                 => '5 SD',
            'foto'                  => 'original/anak_asuh/foto_lama.jpg',
        ], $attributes));
    }

    /**
     * Test fungsi update berhasil memperbarui data teks dan redirect ke route index.
     */
    public function test_update_berhasil_memperbarui_data_dan_redirect_ke_index(): void
    {
        $anakAsuh = $this->buatDummyAnakAsuh();

        $mockImageService = Mockery::mock(ImageService::class);
        $controller = new AnakAsuhController($mockImageService);

        $request = Request::create('/admin/anak-asuh/' . $anakAsuh->id, 'PUT', [
            'nama'                  => 'Budi Santoso Baru',
            'nama_panggilan'        => 'Budi',
            'tempat_lahir'          => 'Bandung',
            'tanggal_lahir'         => '2012-05-10',
            'jenis_kelamin'         => 'L',
            'tinggal_di_lksa_sejak' => '2020',
            'sekolah'               => 'SMP 1',
            'kelas'                 => '7 SMP',
        ]);

        $response = $controller->update($request, $anakAsuh);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('anak-asuh.index'), $response->getTargetUrl());
        $this->assertEquals('Data berhasil diupdate', session('success'));

        // Cek perubahan data pada model
        $this->assertEquals('Budi Santoso Baru', $anakAsuh->fresh()->nama);
        $this->assertEquals('SMP 1', $anakAsuh->fresh()->sekolah);
        $this->assertEquals('original/anak_asuh/foto_lama.jpg', $anakAsuh->fresh()->foto);
    }

    /**
     * Test fungsi update melempar ValidationException jika field wajib tidak diisi.
     */
    public function test_update_melempar_validation_exception_jika_data_wajib_kosong(): void
    {
        $this->expectException(ValidationException::class);

        $anakAsuh = $this->buatDummyAnakAsuh();

        $mockImageService = Mockery::mock(ImageService::class);
        $controller = new AnakAsuhController($mockImageService);

        // Request kosong tanpa nama dan data wajib lainnya
        $request = Request::create('/admin/anak-asuh/' . $anakAsuh->id, 'PUT', []);

        $controller->update($request, $anakAsuh);
    }

    /**
     * Test fungsi update menghapus foto lama dan mengunggah foto baru jika ada file foto.
     */
    public function test_update_mengganti_foto_jika_ada_file_foto_diunggah(): void
    {
        $anakAsuh = $this->buatDummyAnakAsuh(['foto' => 'original/anak_asuh/foto_lama.jpg']);

        $mockImageService = Mockery::mock(ImageService::class);
        $mockImageService->shouldReceive('deleteImage')
            ->once()
            ->with('original/anak_asuh/foto_lama.jpg');
        $mockImageService->shouldReceive('uploadAndGenerateWebp')
            ->once()
            ->andReturn('original/anak_asuh/foto_baru.webp');

        $controller = new AnakAsuhController($mockImageService);

        $foto = UploadedFile::fake()->image('foto_baru.jpg');

        $request = Request::create(
            '/admin/anak-asuh/' . $anakAsuh->id,
            'PUT',
            [
                'nama'                  => 'Budi Setiawan',
                'nama_panggilan'        => 'Budi',
                'tempat_lahir'          => 'Bandung',
                'tanggal_lahir'         => '2012-05-10',
                'jenis_kelamin'         => 'L',
                'tinggal_di_lksa_sejak' => '2020',
                'sekolah'               => 'SD Negeri 1',
                'kelas'                 => '5 SD',
            ],
            [],
            ['foto' => $foto]
        );

        $response = $controller->update($request, $anakAsuh);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals('original/anak_asuh/foto_baru.webp', $anakAsuh->fresh()->foto);
    }
}
