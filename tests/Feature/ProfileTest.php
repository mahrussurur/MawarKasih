<?php

use App\Models\ProfilDonatur;
use App\Models\ProfilPegawai;
use App\Models\User;

it('updates an internal user profile in profil_pegawai while keeping account data in users', function () {
    $user = User::factory()->create([
        'role' => 'ketua',
        'status' => 'aktif',
    ]);
    ProfilPegawai::create([
        'user_id' => $user->id,
        'nama' => 'Nama Lama Ketua',
        'jabatan' => 'Ketua Yayasan',
    ]);

    $this->actingAs($user)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('Nama Lama Ketua')
        ->assertSee('Akun Login');

    $response = $this->actingAs($user)->patch(route('profile.update'), [
        'nama' => 'Ahmad Ketua',
        'username' => 'ahmad.ketua',
        'email' => 'ahmad.ketua@example.test',
        'jabatan' => 'Ketua Pengurus',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '1985-01-20',
        'no_hp' => '081234567890',
        'alamat' => 'Jl. Mawar 1',
        'role' => 'admin',
        'status' => 'tidak_aktif',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHas('status', 'profile-updated');
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'username' => 'ahmad.ketua',
        'email' => 'ahmad.ketua@example.test',
        'role' => 'ketua',
        'status' => 'aktif',
    ]);
    $this->assertDatabaseHas('profil_pegawai', [
        'user_id' => $user->id,
        'nama' => 'Ahmad Ketua',
        'jabatan' => 'Ketua Pengurus',
        'jenis_kelamin' => 'L',
        'tempat_lahir' => 'Bandung',
        'no_hp' => '081234567890',
        'alamat' => 'Jl. Mawar 1',
    ]);
    expect(ProfilPegawai::where('user_id', $user->id)->firstOrFail()->tanggal_lahir->toDateString())
        ->toBe('1985-01-20');
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
