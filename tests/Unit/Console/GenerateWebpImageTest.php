<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

// Menguji method handle() ketika gambar JPG, JPEG, dan PNG berhasil dikonversi
test('gambar JPG JPEG dan PNG berhasil dikonversi menjadi WebP', function () {
    Storage::fake('public');

    // Membuat tiga gambar dengan nama berbeda
    $gambarJpg = UploadedFile::fake()->image('gambar1.jpg', 200, 200);
    $gambarJpeg = UploadedFile::fake()->image('gambar2.jpeg', 200, 200);
    $gambarPng = UploadedFile::fake()->image('gambar3.png', 200, 200);

    // Menyimpan gambar ke folder original
    Storage::disk('public')->putFileAs('original/galeri', $gambarJpg, 'gambar1.jpg');
    Storage::disk('public')->putFileAs('original/galeri', $gambarJpeg, 'gambar2.jpeg');
    Storage::disk('public')->putFileAs('original/galeri', $gambarPng, 'gambar3.png');

    // Menjalankan perintah konversi
    $this->artisan('image:generate-webp')
        ->expectsOutput('Memulai konversi gambar original ke WebP...')
        ->expectsOutput('Berhasil mengonversi 3 gambar ke WebP!')
        ->assertExitCode(0);

    // Memastikan ketiga gambar WebP berhasil dibuat
    Storage::disk('public')->assertExists('webp/galeri/gambar1.webp');
    Storage::disk('public')->assertExists('webp/galeri/gambar2.webp');
    Storage::disk('public')->assertExists('webp/galeri/gambar3.webp');
});

// Menguji method handle() ketika terdapat file dengan ekstensi tidak didukung
test('file selain JPG JPEG dan PNG tidak dikonversi', function () {
    Storage::fake('public');

    // Menyimpan file dengan ekstensi TXT
    Storage::disk('public')->put(
        'original/galeri/dokumen.txt',
        'Isi dokumen pengujian'
    );

    // Menjalankan perintah konversi
    $this->artisan('image:generate-webp')
        ->expectsOutput('Memulai konversi gambar original ke WebP...')
        ->expectsOutput('Berhasil mengonversi 0 gambar ke WebP!')
        ->assertExitCode(0);

    // Memastikan file TXT tetap ada dan tidak dibuat menjadi WebP
    Storage::disk('public')->assertExists('original/galeri/dokumen.txt');
    Storage::disk('public')->assertMissing('webp/galeri/dokumen.webp');
});

// Menguji method handle() ketika folder original tidak memiliki gambar
test('command berhasil dijalankan ketika tidak ada gambar', function () {
    Storage::fake('public');

    // Menjalankan perintah tanpa menyediakan gambar
    $this->artisan('image:generate-webp')
        ->expectsOutput('Memulai konversi gambar original ke WebP...')
        ->expectsOutput('Berhasil mengonversi 0 gambar ke WebP!')
        ->assertExitCode(0);
});

// Menguji method handle() ketika gambar gagal dikonversi
test('command tetap berjalan ketika terdapat gambar yang gagal dikonversi', function () {
    Storage::fake('public');

    // Menyimpan file JPG yang isinya bukan gambar valid
    Storage::disk('public')->put(
        'original/galeri/rusak.jpg',
        'Isi file bukan gambar'
    );

    // Membuat dan menyimpan gambar yang valid
    $gambar = UploadedFile::fake()->image('gambar1.jpg', 200, 200);

    Storage::disk('public')->putFileAs(
        'original/galeri',
        $gambar,
        'gambar1.jpg'
    );

    // Menjalankan perintah konversi
    $this->artisan('image:generate-webp')
        ->expectsOutput('Memulai konversi gambar original ke WebP...')
        ->expectsOutput('Berhasil mengonversi 1 gambar ke WebP!')
        ->assertExitCode(0);

    // Memastikan gambar valid berhasil dikonversi
    Storage::disk('public')->assertExists('webp/galeri/gambar1.webp');

    // Memastikan gambar rusak tidak menghasilkan file WebP
    Storage::disk('public')->assertMissing('webp/galeri/rusak.webp');
});
