<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('public registration creates an active donor account and donor profile', function () {
    $username = 'testuser' . uniqid();
    $email = 'testregister' . uniqid() . '@example.com';

    $response = $this->post('/register', [
        'nama'                  => 'Test User',
        'username'              => $username,
        'email'                 => $email,
        'no_hp'                 => '081234567890',
        'alamat'                => 'Jl. Mawar 10',
        'password'              => 'Password123!',
        'password_confirmation' => 'Password123!',
        // Public input must never be able to elevate the account or disable it.
        'role'                  => 'admin',
        'status'                => 'tidak_aktif',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $user = User::where('username', $username)->firstOrFail();
    expect($user->role)->toBe('donatur')
        ->and($user->status)->toBe('aktif');

    $this->assertDatabaseHas('profil_donatur', [
        'user_id' => $user->id,
        'nama' => 'Test User',
        'no_hp' => '081234567890',
        'alamat' => 'Jl. Mawar 10',
    ]);
});
