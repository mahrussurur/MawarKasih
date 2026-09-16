<?php

use App\Models\ProfilDonatur;
use App\Models\ProfilPengelola;
use App\Models\User;

it('updates an internal user profile in profil_pengelola while keeping account data in users', function () {
    $user = User::factory()->create([
        'role' => 'pengasuh',
        'status' => 'aktif',
    ]);
    ProfilPengelola::create([
        'user_id' => $user->id,
        'nama' => 'Nama Lama Pengasuh',
        'jabatan' => 'Pengasuh',
    ]);

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('Nama Lama Pengasuh')
        ->assertSee('Akun Login');

    $response = $this->actingAs($user)->patch(route('profile.update'), [
        'nama' => 'Siti Pengasuh',
        'username' => 'siti.pengasuh',
        'email' => 'siti.pengasuh@example.test',
        'jabatan' => 'Kepala Pengasuh',
        'jenis_kelamin' => 'P',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '1990-01-20',
        'no_hp' => '081234567890',
        'alamat' => 'Jl. Mawar 1',
        'role' => 'admin',
        'status' => 'tidak_aktif',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHas('status', 'profile-updated');
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'username' => 'siti.pengasuh',
        'email' => 'siti.pengasuh@example.test',
        'role' => 'pengasuh',
        'status' => 'aktif',
    ]);
    $this->assertDatabaseHas('profil_pengelola', [
        'user_id' => $user->id,
        'nama' => 'Siti Pengasuh',
        'jabatan' => 'Kepala Pengasuh',
        'jenis_kelamin' => 'P',
        'tempat_lahir' => 'Bandung',
        'no_hp' => '081234567890',
        'alamat' => 'Jl. Mawar 1',
    ]);
    expect(ProfilPengelola::where('user_id', $user->id)->firstOrFail()->tanggal_lahir->toDateString())
        ->toBe('1990-01-20');
});

it('updates a donor profile in profil_donatur without allowing role or status changes', function () {
    $user = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
    ProfilDonatur::create([
        'user_id' => $user->id,
        'nama' => 'Nama Lama Donatur',
    ]);

    $response = $this->actingAs($user)->patch(route('profile.update'), [
        'nama' => 'Dewi Donatur',
        'username' => 'dewi.donatur',
        'email' => 'dewi.donatur@example.test',
        'no_hp' => '081234567891',
        'alamat' => 'Jl. Anggrek 2',
        'role' => 'admin',
        'status' => 'tidak_aktif',
        'jabatan' => 'Tidak boleh disimpan',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'username' => 'dewi.donatur',
        'email' => 'dewi.donatur@example.test',
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
    $this->assertDatabaseHas('profil_donatur', [
        'user_id' => $user->id,
        'nama' => 'Dewi Donatur',
        'no_hp' => '081234567891',
        'alamat' => 'Jl. Anggrek 2',
    ]);
});
