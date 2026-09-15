<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

function createAdmin(): User
{
    return User::forceCreate([
        'name' => 'Admin Galeri',
        'username' => 'admin-galeri-' . uniqid(),
        'email' => 'admin-galeri-' . uniqid() . '@example.com',
        'password' => bcrypt('password123'),
        'role' => 'admin',
    ]);
}

it('admin dapat menambahkan galeri foto dengan kategori dan deskripsi', function () {
    $admin = createAdmin();

    $response = $this->actingAs($admin)
        ->post(route('galeri.store'), [
            'judul' => 'Aktivitas Pembelajaran',
            'deskripsi' => 'Anak-anak belajar bersama di ruang belajar.',
            'kategori' => 'umum',
            'foto' => UploadedFile::fake()->image('pembelajaran.jpg'),
        ]);

    $response->assertRedirect(route('galeri.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('galeris', [
        'judul' => 'Aktivitas Pembelajaran',
        'kategori' => 'umum',
        'deskripsi' => 'Anak-anak belajar bersama di ruang belajar.',
    ]);
});

it('admin dapat memperbarui dan menghapus galeri', function () {
    $admin = createAdmin();

    $galeri = \App\Models\Galeri::create([
        'judul' => 'Ruang Makan',
        'deskripsi' => 'Ruang makan utama panti.',
        'kategori' => 'fasilitas',
        'foto' => 'galeri/ruang-makan.jpg',
    ]);

    $editResponse = $this->actingAs($admin)
        ->put(route('galeri.update', $galeri), [
            'judul' => 'Ruang Makan Baru',
            'deskripsi' => 'Ruang makan utama panti setelah renovasi.',
            'kategori' => 'fasilitas',
        ]);

    $editResponse->assertRedirect(route('galeri.index'));
    $editResponse->assertSessionHas('success');

    $this->assertDatabaseHas('galeris', [
        'id' => $galeri->id,
        'judul' => 'Ruang Makan Baru',
        'deskripsi' => 'Ruang makan utama panti setelah renovasi.',
        'kategori' => 'fasilitas',
    ]);

    $deleteResponse = $this->actingAs($admin)
        ->delete(route('galeri.destroy', $galeri));

    $deleteResponse->assertRedirect(route('galeri.index'));
    $deleteResponse->assertSessionHas('success');
    $this->assertDatabaseMissing('galeris', ['id' => $galeri->id]);
});

it('admin dapat memfilter galeri berdasarkan kategori', function () {
    $admin = createAdmin();

    \App\Models\Galeri::create([
        'judul' => 'Aktivitas Umum',
        'deskripsi' => 'Foto kegiatan umum panti.',
        'kategori' => 'umum',
        'foto' => 'galeri/umum.jpg',
    ]);

    \App\Models\Galeri::create([
        'judul' => 'Asrama Putri',
        'deskripsi' => 'Foto fasilitas asrama putri.',
        'kategori' => 'fasilitas',
        'foto' => 'galeri/fasilitas.jpg',
    ]);

    $response = $this->actingAs($admin)
        ->get(route('galeri.index', ['kategori' => 'fasilitas']));

    $response->assertOk();
    $response->assertSee('Asrama Putri');
    $response->assertDontSee('Aktivitas Umum');
});
