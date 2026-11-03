<?php

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

use App\Http\Controllers\Admin\AlumniController;
use App\Models\Alumni;
use App\Models\AnakAsuh;
use Illuminate\Http\Request;
use Illuminate\View\View;

// Helper membuat data dummy Alumni
function buatDummyAlumni(array $attributes = []): Alumni
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

test('1. fungsi index() mengembalikan view admin.alumni.index beserta data', function () {
    buatDummyAlumni(['nama' => 'Ahmad Dahlan']);

    $controller = new AlumniController();
    $request = Request::create('/admin/alumni', 'GET');

    $response = $controller->index($request);

    expect($response)->toBeInstanceOf(View::class);
    expect($response->name())->toBe('admin.alumni.index');
    expect($response->getData()['data']->total())->toBe(1);
});

test('2. fungsi index() memfilter data saat request search diisi', function () {
    buatDummyAlumni(['nama' => 'Budi Santoso']);
    buatDummyAlumni(['nama' => 'Siti Aminah']);

    $controller = new AlumniController();

    // Simulasi request dengan parameter ?search=Budi
    $request = Request::create('/admin/alumni', 'GET', ['search' => 'Budi']);

    $response = $controller->index($request);
    $data = $response->getData()['data'];

    expect($data->total())->toBe(1);
    expect($data->first()->nama)->toBe('Budi Santoso');
});

test('3. fungsi index() membatasi pagination sebanyak 10 data', function () {
    for ($i = 1; $i <= 15; $i++) {
        buatDummyAlumni(['nama' => "Alumni {$i}"]);
    }

    $controller = new AlumniController();
    $request = Request::create('/admin/alumni', 'GET');

    $response = $controller->index($request);
    $data = $response->getData()['data'];

    expect($data->count())->toBe(10);
    expect($data->total())->toBe(15);
});

