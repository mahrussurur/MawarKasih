
<?php

use App\Models\AnakAsuh;
use App\Models\Donasi;
use App\Models\Galeri;
use App\Models\Kegiatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


// Pengujian 1: Semua model berhasil memindahkan gambar ke folder original
test('gambar dari semua model berhasil dipindahkan ke folder original', function () {
    Storage::fake('public');

    // Membuat file gambar lama
    Storage::disk('public')->put('anak_asuh/foto_anak.jpg', 'gambar anak');
    Storage::disk('public')->put('kegiatan/foto_kegiatan.jpg', 'gambar kegiatan');
    Storage::disk('public')->put('galeri/foto_galeri.jpg', 'gambar galeri');
    Storage::disk('public')->put('bukti_transfer/bukti.jpg', 'gambar bukti');

    // Membuat data anak asuh
    $anakAsuh = AnakAsuh::forceCreate([
        'foto' => 'anak_asuh/foto_anak.jpg',
        'nama' => 'Andi',
        'tempat_lahir' => 'Banyuwangi',
        'tanggal_lahir' => '2010-01-01',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
    ]);

    // Membuat data kegiatan
    $kegiatan = Kegiatan::forceCreate([
        'nama_kegiatan' => 'Bakti Sosial',
        'tanggal_pelaksanaan' => '2026-01-01',
        'deskripsi' => 'Kegiatan bakti sosial',
        'foto_dokumentasi' => 'kegiatan/foto_kegiatan.jpg',
    ]);

    // Membuat data galeri
    $galeri = Galeri::forceCreate([
        'judul' => 'Kegiatan Yayasan',
        'deskripsi' => 'Dokumentasi kegiatan yayasan',
        'foto' => 'galeri/foto_galeri.jpg',
    ]);

    // Membuat data donasi
    $donasi = Donasi::forceCreate([
        'kode_donasi' => 'DON-20260101-0001',
        'nama_donatur' => 'Budi',
        'nominal' => 100000,
        'tanggal' => '2026-01-01',
        'bukti_transfer' => 'bukti_transfer/bukti.jpg',
        'metode_pembayaran' => 'Transfer',
    ]);

    // Menjalankan command migrasi gambar
    $this->artisan('image:migrate')
        ->assertExitCode(0);

    // Memastikan file berhasil dipindahkan
    Storage::disk('public')->assertExists('original/anak_asuh/foto_anak.jpg');
    Storage::disk('public')->assertExists('original/kegiatan/foto_kegiatan.jpg');
    Storage::disk('public')->assertExists('original/galeri/foto_galeri.jpg');
    Storage::disk('public')->assertExists('original/bukti_transfer/bukti.jpg');

    // Memastikan file lama sudah tidak ada
    Storage::disk('public')->assertMissing('anak_asuh/foto_anak.jpg');
    Storage::disk('public')->assertMissing('kegiatan/foto_kegiatan.jpg');
    Storage::disk('public')->assertMissing('galeri/foto_galeri.jpg');
    Storage::disk('public')->assertMissing('bukti_transfer/bukti.jpg');

    // Memastikan path pada database berhasil diperbarui
    expect($anakAsuh->fresh()->foto)
        ->toBe('original/anak_asuh/foto_anak.jpg')
        ->and($kegiatan->fresh()->foto_dokumentasi)
        ->toBe('original/kegiatan/foto_kegiatan.jpg')
        ->and($galeri->fresh()->foto)
        ->toBe('original/galeri/foto_galeri.jpg')
        ->and($donasi->fresh()->bukti_transfer)
        ->toBe('original/bukti_transfer/bukti.jpg');
});

// Pengujian 2: Path kosong, path original, dan file yang tidak ditemukan dilewati
test('gambar kosong sudah original dan tidak ditemukan dilewati', function () {
    Storage::fake('public');

    // Membuat gambar yang sudah berada di folder original
    Storage::disk('public')->put(
        'original/anak_asuh/foto_lama.jpg',
        'gambar lama'
    );

    // Data dengan path gambar kosong
    $gambarKosong = AnakAsuh::forceCreate([
        'foto' => null,
        'nama' => 'Ani',
        'tempat_lahir' => 'Banyuwangi',
        'tanggal_lahir' => '2011-02-02',
        'jenis_kelamin' => 'P',
        'status_social_anak' => 'Piatu',
    ]);

    // Data dengan path yang sudah berada di folder original
    $gambarOriginal = AnakAsuh::forceCreate([
        'foto' => 'original/anak_asuh/foto_lama.jpg',
        'nama' => 'Bela',
        'tempat_lahir' => 'Banyuwangi',
        'tanggal_lahir' => '2012-03-03',
        'jenis_kelamin' => 'P',
        'status_social_anak' => 'Dhuafa',
    ]);

    // Data dengan file gambar yang tidak ditemukan
    $gambarTidakDitemukan = AnakAsuh::forceCreate([
        'foto' => 'anak_asuh/tidak_ada.jpg',
        'nama' => 'Candra',
        'tempat_lahir' => 'Banyuwangi',
        'tanggal_lahir' => '2013-04-04',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
    ]);

    // Menjalankan command migrasi gambar
    $this->artisan('image:migrate')
        ->assertExitCode(0);

    // Memastikan path database tidak berubah
    expect($gambarKosong->fresh()->foto)
        ->toBeNull()
        ->and($gambarOriginal->fresh()->foto)
        ->toBe('original/anak_asuh/foto_lama.jpg')
        ->and($gambarTidakDitemukan->fresh()->foto)
        ->toBe('anak_asuh/tidak_ada.jpg');

    // Memastikan gambar yang sudah original tetap tersedia
    Storage::disk('public')->assertExists('original/anak_asuh/foto_lama.jpg');

    // Memastikan file yang tidak ditemukan tidak dibuat
    Storage::disk('public')->assertMissing('original/anak_asuh/tidak_ada.jpg');
});

// Pengujian 3: Command berhasil dijalankan ketika tidak ada data
test('migrasi berhasil dijalankan ketika tidak ada data gambar', function () {
    Storage::fake('public');

    $this->artisan('image:migrate')
        ->assertExitCode(0);
});
