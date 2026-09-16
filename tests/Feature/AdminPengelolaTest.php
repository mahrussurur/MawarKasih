<?php

use App\Models\Donasi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('creates a pengasuh account and its shared profile in one request', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'aktif',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.pengelola.store', 'pengasuh'), [
        'nama' => 'Siti Pengasuh',
        'username' => 'siti.pengasuh',
        'email' => 'siti.pengasuh@example.test',
        'password' => 'kata-sandi-aman',
        'status' => 'aktif',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '1990-01-20',
        'jabatan' => 'Pengasuh',
        'jenis_kelamin' => 'P',
        'no_hp' => '081234567890',
        'alamat' => 'Jl. Mawar 1',
    ]);

    $response->assertRedirect(route('admin.pengelola.index', 'pengasuh'));

    $this->assertDatabaseHas('users', [
        'username' => 'siti.pengasuh',
        'email' => 'siti.pengasuh@example.test',
        'role' => 'pengasuh',
        'status' => 'aktif',
    ]);

    $user = User::where('username', 'siti.pengasuh')->firstOrFail();

    $this->assertDatabaseHas('profil_pengelola', [
        'user_id' => $user->id,
        'nama' => 'Siti Pengasuh',
        'jabatan' => 'Pengasuh',
        'no_hp' => '081234567890',
        'alamat' => 'Jl. Mawar 1',
    ]);
    expect(Hash::check('kata-sandi-aman', $user->password))->toBeTrue();

    $this->actingAs($admin)
        ->get(route('admin.pengelola.index', 'pengasuh'))
        ->assertOk()
        ->assertSee('Siti Pengasuh');

    $this->actingAs($admin)
        ->get(route('admin.pengelola.edit', ['pengasuh', $user]))
        ->assertOk()
        ->assertSee('Data Profil')
        ->assertSee('Akun Login');
});

it('limits profile-management creation routes to an admin', function () {
    $pengasuh = User::factory()->create([
        'role' => 'pengasuh',
        'status' => 'aktif',
    ]);

    $this->actingAs($pengasuh)
        ->get(route('admin.pengelola.create', 'bendahara'))
        ->assertForbidden();

    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'aktif',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.pengelola.create', 'bendahara'))
        ->assertOk()
        ->assertSee('Data Profil')
        ->assertSee('Akun Login');

    $this->actingAs($admin)
        ->get(route('admin.pengelola.create', 'donatur'))
        ->assertOk()
        ->assertSee('Data Profil')
        ->assertSee('Akun Login');
});

it('updates the shared profile of an existing manager account', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'aktif',
    ]);
    $bendahara = User::factory()->create([
        'role' => 'bendahara',
        'status' => 'aktif',
    ]);

    $response = $this->actingAs($admin)->put(route('admin.pengelola.update', ['bendahara', $bendahara]), [
        'nama' => 'Budi Bendahara',
        'username' => $bendahara->username,
        'email' => $bendahara->email,
        'status' => 'tidak_aktif',
        'jabatan' => 'Bendahara',
        'jenis_kelamin' => 'L',
        'no_hp' => '081234567899',
        'alamat' => 'Jl. Melati 2',
    ]);

    $response->assertRedirect(route('admin.pengelola.index', 'bendahara'));
    $this->assertDatabaseHas('users', [
        'id' => $bendahara->id,
        'status' => 'tidak_aktif',
    ]);
    $this->assertDatabaseHas('profil_pengelola', [
        'user_id' => $bendahara->id,
        'nama' => 'Budi Bendahara',
        'jabatan' => 'Bendahara',
        'no_hp' => '081234567899',
        'alamat' => 'Jl. Melati 2',
    ]);
});

it('creates a donor account and donor profile from the admin donor form', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'aktif',
    ]);

    $response = $this->actingAs($admin)->post(route('admin.pengelola.store', 'donatur'), [
        'nama' => 'Dewi Donatur',
        'username' => 'dewi.donatur',
        'email' => 'dewi.donatur@example.test',
        'password' => 'kata-sandi-aman',
        'status' => 'aktif',
        'no_hp' => '081234567812',
        'alamat' => 'Jl. Anggrek 5',
    ]);

    $response->assertRedirect(route('admin.pengelola.index', 'donatur'));

    $donatur = User::where('username', 'dewi.donatur')->firstOrFail();
    $this->assertDatabaseHas('users', [
        'id' => $donatur->id,
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
    $this->assertDatabaseHas('profil_donatur', [
        'user_id' => $donatur->id,
        'nama' => 'Dewi Donatur',
        'no_hp' => '081234567812',
        'alamat' => 'Jl. Anggrek 5',
    ]);
    expect(Hash::check('kata-sandi-aman', $donatur->password))->toBeTrue();

    $this->actingAs($admin)
        ->get(route('admin.pengelola.index', ['donatur', 'search' => 'Dewi Donatur']))
        ->assertOk()
        ->assertSee('Dewi Donatur');

    $this->actingAs($admin)
        ->get(route('admin.pengelola.edit', ['donatur', $donatur]))
        ->assertOk()
        ->assertSee('Dewi Donatur')
        ->assertSee('Akun Login');
});

it('updates a donor profile and shows only that donor donation history', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'aktif',
    ]);
    $donatur = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);
    $donaturLain = User::factory()->create([
        'role' => 'donatur',
        'status' => 'aktif',
    ]);

    $response = $this->actingAs($admin)->put(route('admin.pengelola.update', ['donatur', $donatur]), [
        'nama' => 'Rina Donatur',
        'username' => $donatur->username,
        'email' => $donatur->email,
        'status' => 'tidak_aktif',
        'no_hp' => '081234567813',
        'alamat' => 'Jl. Kenanga 7',
    ]);

    $response->assertRedirect(route('admin.pengelola.index', 'donatur'));
    $this->assertDatabaseHas('users', [
        'id' => $donatur->id,
        'status' => 'tidak_aktif',
    ]);
    $this->assertDatabaseHas('profil_donatur', [
        'user_id' => $donatur->id,
        'nama' => 'Rina Donatur',
        'no_hp' => '081234567813',
        'alamat' => 'Jl. Kenanga 7',
    ]);

    Donasi::create([
        'kode_donasi' => 'DON-RINA001',
        'nama_donatur' => 'Rina Donatur',
        'email' => $donatur->email,
        'no_hp' => '081234567813',
        'nominal' => 100000,
        'tanggal' => '2026-09-16',
        'status' => 'diterima',
        'metode_pembayaran' => 'transfer',
        'donatur_id' => $donatur->id,
    ]);
    Donasi::create([
        'kode_donasi' => 'DON-LAIN001',
        'nama_donatur' => 'Donatur Lain',
        'nominal' => 50000,
        'tanggal' => '2026-09-16',
        'status' => 'pending',
        'metode_pembayaran' => 'qris',
        'donatur_id' => $donaturLain->id,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.pengelola.show', ['donatur', $donatur]))
        ->assertOk()
        ->assertSee('DON-RINA001')
        ->assertDontSee('DON-LAIN001');
});
