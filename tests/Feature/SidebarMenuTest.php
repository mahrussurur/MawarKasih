<?php

use App\Models\User;

it('shows the complete administration menu with ketua to admins', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee([
            'Manajemen Akun',
            'Akun User',
            'Data Lembaga',
            'Pegawai',
            'Donatur',
            'Anak Asuh',
            'Alumni',
            'Kegiatan',
            'Galeri',
            'Arsip Dokumen Administrasi',
            'Donasi & keuangan',
            'Donasi',
            'Keuangan',
            'Laporan Bulanan',
        ])
        ->assertDontSee('Data Ketua')
        ->assertDontSee('Data Bendahara')
        ->assertDontSee('Data Pengasuh')
        ->assertDontSee('Data Sekretaris');
});

it('shows finance, donation, report, and profile menus to treasurers only', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);

    $this->actingAs($bendahara)
        ->get(route('bendahara.dashboard'))
        ->assertOk()
        ->assertSee(['Data Donasi', 'Keuangan', 'Laporan Bulanan'])
        ->assertDontSee(['Data Anak Asuh', 'Data Kegiatan', 'Arsip Dokumen Administrasi']);
});

it('shows read-only data, archive, and monthly report menus to ketua', function () {
    $ketua = User::factory()->create(['role' => 'ketua', 'status' => 'aktif']);

    $this->actingAs($ketua)
        ->get(route('ketua.dashboard'))
        ->assertOk()
        ->assertSee([
            'Data Donatur',
            'Data Anak Asuh',
            'Data Alumni',
            'Arsip Dokumen Administrasi',
            'Laporan Bulanan',
        ])
        ->assertDontSee([
            'Data Kegiatan',
            'Galeri',
            'Data User',
            'Data Pengasuh',
            'Data Sekretaris',
        ]);
});

it('shows new donation, donation history, and profile menus to donors only', function () {
    $donatur = User::factory()->create(['role' => 'donatur', 'status' => 'aktif']);

    $this->actingAs($donatur)
        ->get(route('donatur.dashboard'))
        ->assertOk()
        ->assertSee(['Donasi Baru', 'Riwayat Donasi'])
        ->assertDontSee(['Data User', 'Data Anak Asuh', 'Data Kegiatan', 'Arsip Dokumen Administrasi']);
});
