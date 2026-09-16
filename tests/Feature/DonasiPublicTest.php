<?php

use App\Models\ProfilDonatur;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('menyimpan donasi guest dengan data guest dan donatur_id null', function () {
    Storage::fake('public');
    $email = 'guest_test_'.uniqid().'@gmail.com';

    $response = $this->post(route('public.donasi.kirim'), [
        'nama_donatur' => 'Guest Donor',
        'email' => $email,
        'no_hp' => '081234567890',
        'nominal' => 50000,
        'metode_pembayaran' => 'qris',
        'tampilkan_nama' => 'nama_asli',
        'bukti_transfer' => UploadedFile::fake()->image('bukti.jpg'),
        'agree' => true,
        'website' => '',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('donasi', [
        'nama_donatur' => 'Guest Donor',
        'email' => $email,
        'no_hp' => '081234567890',
        'nominal' => 50000,
        'donatur_id' => null,
    ]);
});

it('uses the authenticated donor profile as the donation identity snapshot', function () {
    $donatur = User::factory()->create([
        'email' => 'dina.donatur@example.test',
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
    ProfilDonatur::create([
        'user_id' => $donatur->id,
        'nama' => 'Dina dari Profil',
        'no_hp' => '081234567891',
        'alamat' => 'Jl. Profil Donatur 8',
    ]);

    $this->actingAs($donatur)
        ->get(route('public.donasi.form'))
        ->assertOk()
        ->assertSee('Data identitas donasi diambil dari profil akun Anda')
        ->assertSee('Dina dari Profil');

    $response = $this->actingAs($donatur)->post(route('public.donasi.kirim'), [
        'nominal' => 75000,
        'metode_pembayaran' => 'mandiri',
        'tampilkan_nama' => 'hamba_allah',
        'keterangan' => 'Semoga bermanfaat.',
        // Data berikut tidak boleh dapat mengganti snapshot milik donatur login.
        'nama_donatur' => 'Identitas Palsu',
        'email' => 'palsu@example.test',
        'no_hp' => '089999999999',
        'alamat' => 'Alamat Palsu',
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('donasi', [
        'donatur_id' => $donatur->id,
        'nama_donatur' => 'Dina dari Profil',
        'email' => 'dina.donatur@example.test',
        'no_hp' => '081234567891',
        'alamat' => 'Jl. Profil Donatur 8',
        'nominal' => 75000,
    ]);
});
