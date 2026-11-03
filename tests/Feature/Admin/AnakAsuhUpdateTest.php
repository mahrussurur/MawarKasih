<?php

use App\Models\AnakAsuh;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;

// Helper membuat akun admin
function buatAdmin(): User
{
    return User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
}

// Helper membuat data awal Anak Asuh
function buatAnakAsuhAwal(array $attributes = []): AnakAsuh
{
    return AnakAsuh::create(array_merge([
        'nama'                  => 'Budi Setiawan',
        'nama_panggilan'        => 'Budi',
        'tempat_lahir'          => 'Bandung',
        'tanggal_lahir'         => '2012-05-10',
        'jenis_kelamin'         => 'L',
        'status_social_anak'    => 'Yatim',
        'nama_ayah'             => 'Alm. Hendra',
        'nama_ibu'              => 'Siti',
        'tinggal_di_lksa_sejak' => '2020',
        'sekolah'               => 'SD Negeri 1',
        'kelas'                 => '5 SD',
        'foto'                  => 'original/anak_asuh/foto_lama.jpg',
    ], $attributes));
}

test('1. berhasil memperbarui data anak asuh tanpa mengganti foto', function () {
    $admin = buatAdmin();
    $anakAsuh = buatAnakAsuhAwal();

    // Data baru yang akan disimpan
    $dataBaru = [
        'nama'                  => 'Budi Santoso (Updated)',
        'nama_panggilan'        => 'Budi',
        'tempat_lahir'          => 'Bandung',
        'tanggal_lahir'         => '2012-05-10',
        'jenis_kelamin'         => 'L',
        'status_social_anak'    => 'Yatim',
        'nama_ayah'             => 'Alm. Hendra',
        'nama_ibu'              => 'Siti Rahma',
        'tinggal_di_lksa_sejak' => '2020',
        'sekolah'               => 'SMP Negeri 2',
        'kelas'                 => '7 SMP',
    ];

    $response = $this->actingAs($admin)
        ->put(route('anak-asuh.update', $anakAsuh), $dataBaru);

    // 1. Redirect ke halaman index dengan pesan sukses
    $response->assertRedirect(route('anak-asuh.index'));
    $response->assertSessionHas('success', 'Data berhasil diupdate');

    // 2. Data di database berhasil diperbarui
    $this->assertDatabaseHas('anak_asuh', [
        'id'      => $anakAsuh->id,
        'nama'    => 'Budi Santoso (Updated)',
        'sekolah' => 'SMP Negeri 2',
        'kelas'   => '7 SMP',
        'foto'    => 'original/anak_asuh/foto_lama.jpg', // foto lama tetap bertahan
    ]);
});

test('2. gagal memperbarui data jika field wajib tidak diisi (validasi form)', function () {
    $admin = buatAdmin();
    $anakAsuh = buatAnakAsuhAwal();

    // Kirim data tidak valid (nama kosong dan jenis_kelamin tidak valid)
    $response = $this->actingAs($admin)
        ->from(route('anak-asuh.edit', $anakAsuh))
        ->put(route('anak-asuh.update', $anakAsuh), [
            'nama'          => '',
            'jenis_kelamin' => 'X', // Hanya boleh 'L' atau 'P'
        ]);

    // Harus kembali ke form edit dengan error validasi
    $response->assertRedirect(route('anak-asuh.edit', $anakAsuh));
    $response->assertSessionHasErrors(['nama', 'jenis_kelamin']);

    // Nama lama di database tidak boleh berubah
    expect($anakAsuh->fresh()->nama)->toBe('Budi Setiawan');
});

test('3. berhasil memperbarui data sekaligus mengganti foto baru', function () {
    $admin = buatAdmin();
    $anakAsuh = buatAnakAsuhAwal(['foto' => 'original/anak_asuh/foto_lama.jpg']);

    // Mock ImageService agar tidak perlu upload file fisik sungguhan saat testing
    $mockImageService = Mockery::mock(ImageService::class);
    $mockImageService->shouldReceive('deleteImage')
        ->once()
        ->with('original/anak_asuh/foto_lama.jpg');
    $mockImageService->shouldReceive('uploadAndGenerateWebp')
        ->once()
        ->andReturn('original/anak_asuh/foto_baru.webp');

    $this->app->instance(ImageService::class, $mockImageService);

    $dataBaru = [
        'nama'                  => 'Budi Setiawan',
        'nama_panggilan'        => 'Budi',
        'tempat_lahir'          => 'Bandung',
        'tanggal_lahir'         => '2012-05-10',
        'jenis_kelamin'         => 'L',
        'status_social_anak'    => 'Yatim',
        'tinggal_di_lksa_sejak' => '2020',
        'sekolah'               => 'SD Negeri 1',
        'kelas'                 => '5 SD',
        'foto'                  => UploadedFile::fake()->image('foto_baru.jpg'),
    ];

    $response = $this->actingAs($admin)
        ->put(route('anak-asuh.update', $anakAsuh), $dataBaru);

    $response->assertRedirect(route('anak-asuh.index'));
    $response->assertSessionHas('success', 'Data berhasil diupdate');

    // Pastikan foto pada database terupdate ke foto_baru.webp
    expect($anakAsuh->fresh()->foto)->toBe('original/anak_asuh/foto_baru.webp');
});

