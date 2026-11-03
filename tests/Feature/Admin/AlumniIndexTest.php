<?php

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\User;

// Helper sederhana untuk membuat data dummy Alumni
function buatAlumni(array $attributes = []): Alumni
{
    $anak = AnakAsuh::create([
        'nama' => 'Anak ' . uniqid(),
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '2010-01-01',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
    ]);

    return Alumni::create(array_merge([
        'anak_asuh_id' => $anak->id,
        'nama' => 'Budi Santoso',
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '2000-01-01',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
        'tanggal_keluar' => '2023-01-01',
        'pendidikan_terakhir' => 'SMA',
        'nama_sekolah_terakhir' => 'SMK Negeri 1',
    ], $attributes));
}

test('1. dapat menampilkan halaman daftar alumni dengan view yang benar', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    buatAlumni(['nama' => 'Ahmad Dahlan']);

    $response = $this->actingAs($admin)->get(route('alumni.index'));

    $response->assertOk();
    $response->assertViewIs('admin.alumni.index');
    $response->assertViewHas('data');
    $response->assertSee('Ahmad Dahlan');
});

test('2. dapat mencari alumni berdasarkan nama', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    buatAlumni(['nama' => 'Budi Santoso']);
    buatAlumni(['nama' => 'Siti Aminah']);

    // Cari dengan kata kunci "Budi"
    $response = $this->actingAs($admin)->get(route('alumni.index', ['search' => 'Budi']));

    $response->assertOk();
    $response->assertSee('Budi Santoso');
    $response->assertDontSee('Siti Aminah');
});

test('3. dapat mencari alumni berdasarkan nama sekolah atau pendidikan terakhir', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    buatAlumni([
        'nama' => 'Rian Hidayat',
        'nama_sekolah_terakhir' => 'SMK TI Mawar Kasih',
        'pendidikan_terakhir' => 'SMK',
    ]);
    buatAlumni([
        'nama' => 'Doni Siregar',
        'nama_sekolah_terakhir' => 'SMA Negeri 5',
        'pendidikan_terakhir' => 'SMA',
    ]);

    // Cari dengan nama sekolah
    $response = $this->actingAs($admin)->get(route('alumni.index', ['search' => 'Mawar Kasih']));
    $response->assertSee('Rian Hidayat');
    $response->assertDontSee('Doni Siregar');

    // Cari dengan pendidikan terakhir
    $response = $this->actingAs($admin)->get(route('alumni.index', ['search' => 'SMK']));
    $response->assertSee('Rian Hidayat');
    $response->assertDontSee('Doni Siregar');
});

test('4. data alumni dibatasi 10 item per halaman (pagination)', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    // Buat 15 alumni
    for ($i = 1; $i <= 15; $i++) {
        buatAlumni(['nama' => "Alumni {$i}"]);
    }

    $response = $this->actingAs($admin)->get(route('alumni.index'));

    $response->assertOk();
    $data = $response->viewData('data');
    expect($data->count())->toBe(10);
    expect($data->total())->toBe(15);
});

