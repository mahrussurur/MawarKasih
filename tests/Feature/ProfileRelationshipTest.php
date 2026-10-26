<?php

use App\Models\ProfilDonatur;
use App\Models\ProfilPegawai;
use App\Models\User;

it('relates an internal account to its shared pegawai profile', function () {
    $user = User::factory()->create(['role' => 'ketua']);

    $profile = ProfilPegawai::create([
        'user_id' => $user->id,
        'nama' => 'Ketua Uji',
        'jabatan' => 'Ketua Yayasan',
        'no_hp' => '081234567890',
    ]);

    expect($user->profilPegawai->is($profile))->toBeTrue();
    expect($profile->user->is($user))->toBeTrue();
});

it('relates a donor account to its donor profile', function () {
    $user = User::factory()->create(['role' => 'donatur']);

    $profile = ProfilDonatur::create([
        'user_id' => $user->id,
        'nama' => 'Donatur Uji',
        'no_hp' => '081234567891',
        'alamat' => 'Bandung',
    ]);

    expect($user->profilDonatur->is($profile))->toBeTrue();
    expect($profile->user->is($user))->toBeTrue();
});
