<?php

use App\Models\User;

it('allows each role to access its assigned feature area', function (string $role, string $routeName) {
    $user = User::factory()->create(['role' => $role, 'status' => 'aktif']);

    $this->actingAs($user)->get(route($routeName))->assertOk();
})->with([
    'admin' => ['admin', 'admin.dashboard'],
    'bendahara' => ['bendahara', 'bendahara.keuangan.index'],
    'sekretaris' => ['sekretaris', 'sekretaris.kegiatan.index'],
    'pengasuh' => ['pengasuh', 'pengasuh.anak-asuh.index'],
    'donatur' => ['donatur', 'donatur.donasi.index'],
]);

it('allows admins to use every internal role area', function (string $routeName) {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    $this->actingAs($admin)->get(route($routeName))->assertOk();
})->with([
    'finance' => 'bendahara.keuangan.index',
    'foundation content' => 'sekretaris.kegiatan.index',
    'child care' => 'pengasuh.anak-asuh.index',
    'donor history area' => 'donatur.donasi.index',
]);

it('denies non-admin roles from unrelated internal areas', function (string $role, string $routeName) {
    $user = User::factory()->create(['role' => $role, 'status' => 'aktif']);

    $this->actingAs($user)->get(route($routeName))->assertForbidden();
})->with([
    'bendahara to secretary' => ['bendahara', 'sekretaris.kegiatan.index'],
    'sekretaris to child care' => ['sekretaris', 'pengasuh.anak-asuh.index'],
    'pengasuh to finance' => ['pengasuh', 'bendahara.keuangan.index'],
    'donatur to user administration' => ['donatur', 'users.index'],
]);
