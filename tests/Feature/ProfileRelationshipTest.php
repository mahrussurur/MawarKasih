<?php

use App\Models\ProfilDonatur;
use App\Models\ProfilPengelola;
use App\Models\User;

it('relates an internal account to its shared manager profile', function () {
    $user = User::factory()->create(['role' => 'pengasuh']);

    $profile = ProfilPengelola::create([
        'user_id' => $user->id,
        'nama' => 'Pengasuh Uji',
        'jabatan' => 'Pengasuh',
        'no_hp' => '081234567890',
    ]);

    expect($user->profilPengelola->is($profile))->toBeTrue();
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
