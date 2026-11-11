<?php

use App\Models\Donasi;
use App\Models\ProfilDonatur;
use App\Models\ProfilPegawai;
use App\Models\User;
use Illuminate\Support\Carbon;

test('user model casts email_verified_at and password correctly', function () {
    $user = User::factory()->create([
        'email_verified_at' => '2026-01-01 10:00:00',
        'password' => 'plainpassword123',
    ]);

    expect($user->email_verified_at)->toBeInstanceOf(Carbon::class);
    expect($user->password)->not->toBe('plainpassword123');
});

test('user has one profil pegawai', function () {
    $user = User::factory()->create(['role' => 'admin']);
    $profile = ProfilPegawai::create([
        'user_id' => $user->id,
        'nama' => 'Staff Name',
        'jabatan' => 'Admin',
    ]);

    expect($user->profilPegawai)->toBeInstanceOf(ProfilPegawai::class)
        ->and($user->profilPegawai->id)->toBe($profile->id);
});

test('user has one profil donatur', function () {
    $user = User::factory()->create(['role' => 'donatur']);
    $profile = ProfilDonatur::create([
        'user_id' => $user->id,
        'nama' => 'Donatur Name',
    ]);

    expect($user->profilDonatur)->toBeInstanceOf(ProfilDonatur::class)
        ->and($user->profilDonatur->id)->toBe($profile->id);
});

test('user has many donasi', function () {
    $user = User::factory()->create(['role' => 'donatur']);
    $donasi = Donasi::create([
        'kode_donasi' => 'DON-UNIT-01',
        'nama_donatur' => 'Donatur Name',
        'nominal' => 50000,
        'tanggal' => now(),
        'status' => 'diterima',
        'metode_pembayaran' => 'transfer',
        'donatur_id' => $user->id,
    ]);

    expect($user->donasi)->toHaveCount(1)
        ->and($user->donasi->first()->kode_donasi)->toBe('DON-UNIT-01');
});

test('get nama attribute returns profile name or falls back to username', function () {
    $userPegawai = User::factory()->create(['role' => 'admin', 'username' => 'admin_user']);
    ProfilPegawai::create([
        'user_id' => $userPegawai->id,
        'nama' => 'Nama Asli Pegawai',
        'jabatan' => 'Admin',
    ]);

    expect($userPegawai->nama)->toBe('Nama Asli Pegawai');

    $userTanpaProfil = User::factory()->create(['role' => 'admin', 'username' => 'user_polos']);
    expect($userTanpaProfil->nama)->toBe('user_polos');
});
