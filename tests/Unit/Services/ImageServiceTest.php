
<?php

use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


// Menguji method __construct()
test('ImageService berhasil membuat ImageManager', function () {
    $imageService = new ImageService();

    expect($imageService)->toBeInstanceOf(ImageService::class);
});

// Menguji method uploadAndGenerateWebp()
test('gambar berhasil diunggah dan dibuat dalam format WebP', function () {
    Storage::fake('public');

    $imageService = new ImageService();

    $file = UploadedFile::fake()->image('foto.jpg', 200, 200);

    $hasil = $imageService->uploadAndGenerateWebp($file, 'galeri');

    // Memastikan gambar asli berhasil disimpan
    Storage::disk('public')->assertExists($hasil);

    // Membuat lokasi file WebP berdasarkan lokasi gambar asli
    $namaFile = pathinfo($hasil, PATHINFO_FILENAME);
    $webpPath = 'webp/galeri/' . $namaFile . '.webp';

    // Memastikan gambar WebP berhasil dibuat
    Storage::disk('public')->assertExists($webpPath);
});

// Menguji method deleteImage() ketika gambar asli dan WebP tersedia
test('gambar asli dan WebP berhasil dihapus', function () {
    Storage::fake('public');

    $imageService = new ImageService();

    $originalPath = 'original/galeri/foto.jpg';
    $webpPath = 'webp/galeri/foto.webp';

    Storage::disk('public')->put($originalPath, 'gambar asli');
    Storage::disk('public')->put($webpPath, 'gambar webp');

    $imageService->deleteImage($originalPath);

    Storage::disk('public')->assertMissing($originalPath);
    Storage::disk('public')->assertMissing($webpPath);
});

// Menguji method deleteImage() ketika lokasi gambar kosong
test('penghapusan gambar tidak dilakukan jika lokasi gambar kosong', function () {
    Storage::fake('public');

    $imageService = new ImageService();

    $hasil = $imageService->deleteImage(null);

    expect($hasil)->toBeNull();
});

// Menguji method deleteImage() ketika gambar asli tidak ditemukan
test('penghapusan gambar tetap berjalan jika gambar asli tidak ditemukan', function () {
    Storage::fake('public');

    $imageService = new ImageService();

    $originalPath = 'original/galeri/foto.jpg';
    $webpPath = 'webp/galeri/foto.webp';

    Storage::disk('public')->put($webpPath, 'gambar webp');

    $imageService->deleteImage($originalPath);

    Storage::disk('public')->assertMissing($originalPath);
    Storage::disk('public')->assertMissing($webpPath);
});
