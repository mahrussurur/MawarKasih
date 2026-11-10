<?php

use App\Models\User;

// Menguji halaman registrasi berhasil ditampilkan
test('halaman registrasi berhasil ditampilkan', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

// Menguji registrasi donatur berhasil
test('registrasi donatur berhasil membuat akun dan profil donatur', function () {
    $username = 'pengguna' . uniqid();
    $email = 'registrasi' . uniqid() . '@example.com';

    $response = $this->post('/register', [
        'nama' => 'Diana Eka',
        'username' => $username,
        'email' => $email,
        'no_hp' => '081234567890',
        'alamat' => 'Banyuwangi',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',

        // Memastikan pengguna tidak dapat mengubah hak akses dan status akun
        'role' => 'admin',
        'status' => 'tidak_aktif',
    ]);

    $this->assertAuthenticated();

    $response->assertRedirect(route('dashboard', absolute: false));

    $user = User::where('username', $username)->firstOrFail();

    expect($user->role)->toBe('donatur')
        ->and($user->status)->toBe('aktif');

    $this->assertDatabaseHas('profil_donatur', [
        'user_id' => $user->id,
        'nama' => 'Diana Eka',
        'no_hp' => '081234567890',
        'alamat' => 'Banyuwangi',
    ]);
});

// Menguji registrasi gagal jika username dan email sudah digunakan
test('registrasi gagal jika username dan email sudah digunakan', function () {
    User::create([
        'username' => 'dianaeka',
        'email' => 'diana@gmail.com',
        'password' => bcrypt('Password123!'),
        'role' => 'donatur',
        'status' => 'aktif',
    ]);

    $response = $this->from('/register')->post('/register', [
        'nama' => 'Diana Eka',
        'username' => 'dianaeka',
        'email' => 'diana@gmail.com',
        'no_hp' => '081234567890',
        'alamat' => 'Banyuwangi',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors(['username', 'email']);
});

// Menguji registrasi gagal jika nomor HP tidak valid
test('registrasi gagal jika nomor HP tidak valid', function () {
    $response = $this->from('/register')->post('/register', [
        'nama' => 'Diana Eka',
        'username' => 'dianaeka',
        'email' => 'diana@gmail.com',
        'no_hp' => '0812abc',
        'alamat' => 'Banyuwangi',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors('no_hp');
});

// Menguji registrasi gagal jika konfirmasi password tidak sesuai
test('registrasi gagal jika konfirmasi password tidak sesuai', function () {
    $response = $this->from('/register')->post('/register', [
        'nama' => 'Diana Eka',
        'username' => 'dianaeka',
        'email' => 'diana@gmail.com',
        'no_hp' => '081234567890',
        'alamat' => 'Banyuwangi',
        'password' => 'Password123!',
        'password_confirmation' => 'Password456!',
    ]);

    $response->assertRedirect('/register');
    $response->assertSessionHasErrors('password');
});
