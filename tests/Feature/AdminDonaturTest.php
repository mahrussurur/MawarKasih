<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('allows admin to view, create, edit and delete donatur via dedicated donatur routes', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    // Create Donatur
    $response = $this->actingAs($admin)->post(route('admin.donatur.store'), [
        'nama' => 'Hamba Allah',
        'username' => 'hamba.allah',
        'email' => 'hamba@example.test',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'no_hp' => '081234567890',
        'alamat' => 'Surabaya',
    ]);

    $response->assertRedirect(route('admin.donatur.index'));

    $this->assertDatabaseHas('users', [
        'username' => 'hamba.allah',
        'email' => 'hamba@example.test',
        'role' => 'donatur',
    ]);

    $donatur = User::where('username', 'hamba.allah')->firstOrFail();
    $this->assertDatabaseHas('profil_donatur', [
        'user_id' => $donatur->id,
        'nama' => 'Hamba Allah',
        'no_hp' => '081234567890',
        'alamat' => 'Surabaya',
    ]);

    // View Index
    $this->actingAs($admin)->get(route('admin.donatur.index'))
        ->assertOk()
        ->assertSee('Hamba Allah')
        ->assertSee('hamba.allah');

    // View Show
    $this->actingAs($admin)->get(route('admin.donatur.show', $donatur->id))
        ->assertOk()
        ->assertSee('Hamba Allah')
        ->assertSee('Surabaya');

    // Update
    $response = $this->actingAs($admin)->put(route('admin.donatur.update', $donatur->id), [
        'nama' => 'Hamba Allah Update',
        'username' => 'hamba.allah',
        'email' => 'hamba@example.test',
        'no_hp' => '089999999999',
        'alamat' => 'Malang',
    ]);

    $response->assertRedirect(route('admin.donatur.index'));
    $this->assertDatabaseHas('profil_donatur', [
        'user_id' => $donatur->id,
        'nama' => 'Hamba Allah Update',
        'no_hp' => '089999999999',
        'alamat' => 'Malang',
    ]);

    // Delete
    $response = $this->actingAs($admin)->delete(route('admin.donatur.destroy', $donatur->id));
    $response->assertRedirect(route('admin.donatur.index'));
    $this->assertDatabaseMissing('users', ['id' => $donatur->id]);
    $this->assertDatabaseMissing('profil_donatur', ['user_id' => $donatur->id]);
});
