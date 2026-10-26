<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

it('keeps only account fields in users after profile cleanup', function () {
    expect(Schema::hasColumns('users', [
        'username',
        'email',
        'email_verified_at',
        'password',
        'role',
        'status',
        'remember_token',
        'created_at',
        'updated_at',
    ]))->toBeTrue();

    expect(Schema::hasColumns('users', [
        'name',
        'foto',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'jabatan',
        'jenis_kelamin',
        'no_hp',
    ]))->toBeFalse();
});

it('updates account credentials, status, and role', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);
    $user = User::factory()->create(['role' => 'donatur', 'status' => 'aktif']);

    $response = $this->actingAs($admin)->patch(route('users.update', $user), [
        'username' => 'user.diperbarui',
        'email' => 'user.diperbarui@example.test',
        'password' => 'kata-sandi-baru',
        'password_confirmation' => 'kata-sandi-baru',
        'status' => 'tidak_aktif',
        'role' => 'bendahara',
    ]);

    $response->assertRedirect(route('users.index'));
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'username' => 'user.diperbarui',
        'email' => 'user.diperbarui@example.test',
        'role' => 'bendahara',
        'status' => 'tidak_aktif',
    ]);
    expect(Hash::check('kata-sandi-baru', $user->fresh()->password))->toBeTrue();
});
