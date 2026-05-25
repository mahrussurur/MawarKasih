<?php

use App\Models\Donasi;
use App\Models\Donatur;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('menyimpan donasi guest dengan data guest dan donatur_id null', function () {
    Storage::fake('public');

    $response = $this->post(route('public.donasi.kirim'), [
        'nama_donatur' => 'Guest Donor',
        'email' => 'guest@example.com',
        'no_hp' => '081234567890',
        'nominal' => 50000,
        'bukti_transfer' => UploadedFile::fake()->image('bukti.jpg'),
        'agree' => true,
        'website' => '',
    ]);

    $response->assertRedirect(route('public.home'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('donasi', [
        'nama_donatur' => 'Guest Donor',
        'no_hp' => '081234567890',
        'nominal' => 50000,
        'donatur_id' => null,
        'keterangan' => 'Guest',
    ]);
});

it('menyimpan donasi donatur tetap dengan donatur_id dan data profil tetap', function () {
    Storage::fake('public');

    $donatur = Donatur::create([
        'nama' => 'Tetap Donor',
        'email' => 'tetap@example.com',
        'no_hp' => '081234567891',
        'alamat' => 'Jl. Contoh No. 1',
        'password' => bcrypt('password123'),
        'status' => 'aktif',
    ]);

    $response = $this->withSession(['donatur_id' => $donatur->id])
        ->post(route('public.donasi.kirim'), [
            'nominal' => 75000,
            'bukti_transfer' => UploadedFile::fake()->image('bukti-tetap.jpg'),
            'agree' => true,
            'website' => '',
        ]);

    $response->assertRedirect(route('public.home'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('donasi', [
        'nama_donatur' => 'Tetap Donor',
        'no_hp' => '081234567891',
        'nominal' => 75000,
        'donatur_id' => $donatur->id,
        'keterangan' => 'Donatur Tetap',
    ]);
});
