
<?php

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

// Memuat helper setelah aplikasi Laravel dijalankan
beforeEach(function () {
    require_once app_path('Helpers/ImageHelper.php');
});

// Menguji get_webp_url() ketika path gambar kosong
test('get webp url mengembalikan logo jika path gambar kosong', function () {
    $hasil = get_webp_url(null);

    expect($hasil)->toBe(asset('images/logo.webp'));
});

// Menguji get_webp_url() ketika path bukan original
test('get webp url mengembalikan url asli jika path bukan original', function () {
    Storage::fake('public');

    $path = 'galeri/foto.jpg';

    $hasil = get_webp_url($path);

    expect($hasil)->toBe(Storage::url($path));
});

// Menguji get_webp_url() ketika path diawali original
test('get webp url mengubah path original menjadi webp', function () {
    Storage::fake('public');

    $path = 'original/galeri/foto.jpg';

    $hasil = get_webp_url($path);

    expect($hasil)->toBe(Storage::url('webp/galeri/foto.webp'));
});
