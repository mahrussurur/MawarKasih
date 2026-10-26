<?php

use App\Models\User;

it('allows each active role to access its assigned feature area', function (string $role, string $routeName) {
    $user = User::factory()->create(['role' => $role, 'status' => 'aktif']);

    $this->actingAs($user)->get(route($routeName))->assertOk();
})->with([
    'admin' => ['admin', 'admin.dashboard'],
    'admin archive' => ['admin', 'admin.arsip-dokumen.index'],
    'bendahara' => ['bendahara', 'bendahara.keuangan.index'],
    'ketua' => ['ketua', 'ketua.dashboard'],
    'donatur' => ['donatur', 'donatur.donasi.index'],
]);

it('allows ketua to access read-only resources, archives, and monthly reports', function (string $routeName) {
    $ketua = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);

    $this->actingAs($ketua)->get(route($routeName))->assertOk();
})->with([
    'donatur list' => 'ketua.donatur.index',
    'anak asuh list' => 'ketua.anak-asuh.index',
    'alumni list' => 'ketua.alumni.index',
    'arsip dokumen' => 'ketua.arsip-dokumen.index',
    'laporan bulanan' => 'ketua.laporan-bulanan.index',
]);

it('denies admins from ketua exclusive areas like document archives', function (string $routeName) {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    $this->actingAs($admin)->get(route($routeName))->assertForbidden();
})->with([
    'arsip dokumen' => 'ketua.arsip-dokumen.index',
]);

it('denies non-admin roles from unrelated internal areas', function (string $role, string $routeName) {
    $user = User::factory()->create(['role' => $role, 'status' => 'aktif']);

    $this->actingAs($user)->get(route($routeName))->assertForbidden();
})->with([
    'bendahara to ketua archive' => ['bendahara', 'ketua.arsip-dokumen.index'],
    'bendahara to admin archive' => ['bendahara', 'admin.arsip-dokumen.index'],
    'ketua to bendahara finance' => ['ketua', 'bendahara.keuangan.index'],
    'ketua to admin archive' => ['ketua', 'admin.arsip-dokumen.index'],
    'donatur to user administration' => ['donatur', 'users.index'],
    'donatur to ketua archive' => ['donatur', 'ketua.arsip-dokumen.index'],
    'donatur to admin archive' => ['donatur', 'admin.arsip-dokumen.index'],
]);
