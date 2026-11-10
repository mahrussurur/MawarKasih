<?php

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;

test('profile update request rules for donatur role contains only basic account fields', function () {
    $donatur = User::factory()->create([
        'role' => 'donatur',
    ]);

    $request = ProfileUpdateRequest::create('/profile', 'PATCH');
    $request->setUserResolver(fn () => $donatur);

    $rules = $request->rules();

    expect($rules)->toHaveKeys(['nama', 'username', 'email', 'no_hp', 'alamat']);
    expect($rules)->not->toHaveKey('foto');
    expect($rules)->not->toHaveKey('jabatan');
    expect($rules)->not->toHaveKey('tempat_lahir');
    expect($rules)->not->toHaveKey('tanggal_lahir');
});

test('profile update request rules for non-donatur role includes employee fields', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $request = ProfileUpdateRequest::create('/profile', 'PATCH');
    $request->setUserResolver(fn () => $admin);

    $rules = $request->rules();

    expect($rules)->toHaveKeys([
        'nama',
        'username',
        'email',
        'no_hp',
        'alamat',
        'foto',
        'jabatan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
    ]);
});

