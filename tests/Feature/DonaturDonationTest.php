<?php

use App\Models\Donasi;
use App\Models\User;

it('shows a donor only their own donation history and details', function () {
    $donatur = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
    $donaturLain = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);

    $donasiMilikSendiri = Donasi::create([
        'kode_donasi' => 'DON-MILIK-SAYA',
        'nama_donatur' => 'Donatur Saya',
        'email' => $donatur->email,
        'no_hp' => '081234567890',
        'nominal' => 50000,
        'tanggal' => '2026-09-16',
        'status' => 'pending',
        'metode_pembayaran' => 'qris',
        'donatur_id' => $donatur->id,
    ]);
    $donasiMilikOrangLain = Donasi::create([
        'kode_donasi' => 'DON-MILIK-LAIN',
        'nama_donatur' => 'Donatur Lain',
        'email' => $donaturLain->email,
        'no_hp' => '081234567891',
        'nominal' => 75000,
        'tanggal' => '2026-09-16',
        'status' => 'pending',
        'metode_pembayaran' => 'mandiri',
        'donatur_id' => $donaturLain->id,
    ]);

    $this->actingAs($donatur)
        ->get(route('donatur.donasi.index'))
        ->assertOk()
        ->assertSee($donasiMilikSendiri->kode_donasi)
        ->assertDontSee($donasiMilikOrangLain->kode_donasi);

    $this->actingAs($donatur)
        ->get(route('donatur.donasi.show', $donasiMilikOrangLain))
        ->assertNotFound();
});
