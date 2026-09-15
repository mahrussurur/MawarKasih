<?php

use App\Models\Donasi;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('menyimpan donasi guest dengan data guest dan donatur_id null', function () {
    Storage::fake('public');

    $response = $this->post(route('public.donasi.kirim'), [
        'nama_donatur'      => 'Guest Donor',
        'email'             => 'guest_test_' . time() . '@gmail.com',
        'no_hp'             => '081234567890',
        'nominal'           => 50000,
        'metode_pembayaran' => 'qris',
        'tampilkan_nama'    => 'nama_asli',
        'bukti_transfer'    => UploadedFile::fake()->image('bukti.jpg'),
        'agree'             => true,
        'website'           => '',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('donasi', [
        'nama_donatur' => 'Guest Donor',
        'no_hp'        => '081234567890',
        'nominal'      => 50000,
        'donatur_id'   => null,
    ]);
});
