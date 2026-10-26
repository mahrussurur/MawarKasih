<?php

use App\Models\ProfilPegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('displays the list of all staff (admin, ketua, bendahara, pengasuh) in data pegawai', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    ProfilPegawai::create([
        'user_id' => $admin->id,
        'nama' => 'Admin Utama',
        'jabatan' => 'Admin',
    ]);

    $ketua = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);
    ProfilPegawai::create([
        'user_id' => $ketua->id,
        'nama' => 'Ketua Yayasan',
        'jabatan' => 'Ketua',
    ]);

    // Pengasuh without user account
    ProfilPegawai::create([
        'user_id' => null,
        'nama' => 'Ibu Asuh Siti',
        'jabatan' => 'Pengasuh',
        'no_hp' => '081234567899',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.pegawai.index'));

    $response->assertOk()
        ->assertSee('Admin Utama')
        ->assertSee('Ketua Yayasan')
        ->assertSee('Ibu Asuh Siti')
        ->assertSee('Pengasuh')
        ->assertSee('Tanpa Akun Login');
});

it('allows admin to create a new pengasuh without login account and without user role', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    $response = $this->actingAs($admin)->post(route('admin.pegawai.store'), [
        'nama' => 'Bapak Pengasuh Budi',
        'jabatan' => 'Pengasuh',
        'tempat_lahir' => 'Banyuwangi',
        'tanggal_lahir' => '1990-05-15',
        'jenis_kelamin' => 'L',
        'no_hp' => '081234567800',
        'alamat' => 'Asrama Putra',
    ]);

    $response->assertRedirect(route('admin.pegawai.index'));

    $this->assertDatabaseHas('profil_pegawai', [
        'nama' => 'Bapak Pengasuh Budi',
        'jabatan' => 'Pengasuh',
        'user_id' => null,
        'no_hp' => '081234567800',
    ]);

    // Role pengasuh must NOT exist in users table
    $this->assertDatabaseMissing('users', [
        'username' => 'Bapak Pengasuh Budi',
    ]);
});

it('allows admin to create a staff member with login credentials', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    $response = $this->actingAs($admin)->post(route('admin.pegawai.store'), [
        'nama' => 'Siti Bendahara',
        'jabatan' => 'Bendahara',
        'tempat_lahir' => 'Surabaya',
        'tanggal_lahir' => '1988-08-20',
        'jenis_kelamin' => 'P',
        'no_hp' => '081298765432',
        'alamat' => 'Kantor Keuangan',
        'buat_akun_login' => '1',
        'username' => 'siti.bendahara',
        'email' => 'siti@example.test',
        'role' => 'bendahara',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('admin.pegawai.index'));

    $this->assertDatabaseHas('users', [
        'username' => 'siti.bendahara',
        'email' => 'siti@example.test',
        'role' => 'bendahara',
        'status' => 'aktif',
    ]);

    $user = User::where('username', 'siti.bendahara')->firstOrFail();
    $this->assertDatabaseHas('profil_pegawai', [
        'user_id' => $user->id,
        'nama' => 'Siti Bendahara',
        'jabatan' => 'Bendahara',
    ]);
    expect(Hash::check('password123', $user->password))->toBeTrue();
});

it('allows admin to edit a pegawai profile', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    $pegawai = ProfilPegawai::create([
        'nama' => 'Pengasuh Lama',
        'jabatan' => 'Pengasuh',
        'no_hp' => '081111111111',
    ]);

    $response = $this->actingAs($admin)->put(route('admin.pegawai.update', $pegawai->id), [
        'nama' => 'Pengasuh Baru',
        'jabatan' => 'Pengasuh',
        'no_hp' => '082222222222',
        'alamat' => 'Alamat Terupdate',
    ]);

    $response->assertRedirect(route('admin.pegawai.index'));

    $this->assertDatabaseHas('profil_pegawai', [
        'id' => $pegawai->id,
        'nama' => 'Pengasuh Baru',
        'no_hp' => '082222222222',
        'alamat' => 'Alamat Terupdate',
    ]);
});

it('allows admin to add a login account for a staff member who was created without an account', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    // Pegawai Ketua dibuat tanpa akun login
    $ketuaPegawai = ProfilPegawai::create([
        'user_id' => null,
        'nama' => 'Drs. H. Ahmad Ketua',
        'jabatan' => 'Ketua',
        'no_hp' => '081234567888',
        'alamat' => 'Kantor Yayasan',
    ]);

    // Admin membuka halaman edit
    $this->actingAs($admin)
        ->get(route('admin.pegawai.edit', $ketuaPegawai->id))
        ->assertOk()
        ->assertSee('Tambahkan Akun Login')
        ->assertSee('Buat Akun Login');

    // Admin menambahkan akun login untuk Ketua
    $response = $this->actingAs($admin)->put(route('admin.pegawai.update', $ketuaPegawai->id), [
        'nama' => 'Drs. H. Ahmad Ketua',
        'jabatan' => 'Ketua',
        'no_hp' => '081234567888',
        'alamat' => 'Kantor Yayasan',
        'buat_akun_login' => '1',
        'username' => 'ahmad.ketua',
        'email' => 'ahmad.ketua@example.test',
        'role' => 'ketua',
        'status' => 'aktif',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('admin.pegawai.index'));

    // Verifikasi akun user berhasil dibuat di tabel users
    $this->assertDatabaseHas('users', [
        'username' => 'ahmad.ketua',
        'email' => 'ahmad.ketua@example.test',
        'role' => 'ketua',
        'status' => 'aktif',
    ]);

    $newUser = User::where('username', 'ahmad.ketua')->firstOrFail();
    expect(Hash::check('password123', $newUser->password))->toBeTrue();

    // Verifikasi profil pegawai telah terhubung dengan user baru
    $ketuaPegawai->refresh();
    expect($ketuaPegawai->user_id)->toBe($newUser->id);
});

it('allows admin to delete a pegawai and deletes linked user account', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    $user = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);
    $pegawai = ProfilPegawai::create([
        'user_id' => $user->id,
        'nama' => 'Ketua Dihapus',
        'jabatan' => 'Ketua',
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.pegawai.destroy', $pegawai->id));

    $response->assertRedirect(route('admin.pegawai.index'));

    $this->assertDatabaseMissing('profil_pegawai', ['id' => $pegawai->id]);
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});
