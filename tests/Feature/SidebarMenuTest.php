<?php

use App\Models\User;

it('shows the complete administration menu only to admins', function () {
    $admin = User::factory()->create(['role' => 'admin', 'status' => 'aktif']);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee([
            'Manajemen Akun',
            'Data User',
            'Data Anak Asuh',
            'Data Pengasuh',
            'Data Bendahara',
            'Data Sekretaris',
            'Data Donatur',
            'Data Kegiatan',
            'Galeri',
            'Donasi',
            'Transaksi Keuangan',
            'Laporan Keuangan',
            'Profil Saya',
        ])
        ->assertDontSee('Dokumen Administrasi');
});

it('shows finance, donation, report, and profile menus to treasurers only', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);

    $this->actingAs($bendahara)
        ->get(route('bendahara.dashboard'))
        ->assertOk()
        ->assertSee(['Data Donasi', 'Transaksi Keuangan', 'Laporan Keuangan', 'Profil Saya'])
        ->assertDontSee(['Data Anak Asuh', 'Data Kegiatan', 'Dokumen Administrasi']);
});

it('shows only foundation content and profile menus to secretaries', function () {
    $sekretaris = User::factory()->create(['role' => 'sekretaris', 'status' => 'aktif']);

    $this->actingAs($sekretaris)
        ->get(route('sekretaris.dashboard'))
        ->assertOk()
        ->assertSee(['Data Kegiatan', 'Galeri', 'Profil Saya'])
        ->assertDontSee(['Data Donasi', 'Transaksi Keuangan', 'Dokumen Administrasi']);
});

it('shows child-care and profile menus to caregivers only', function () {
    $pengasuh = User::factory()->create(['role' => 'pengasuh', 'status' => 'aktif']);

    $this->actingAs($pengasuh)
        ->get(route('pengasuh.dashboard'))
        ->assertOk()
        ->assertSee(['Data Anak Asuh', 'Profil Saya'])
        ->assertDontSee(['Data Donasi', 'Data Kegiatan', 'Catatan Perkembangan']);
});

it('shows new donation, donation history, and profile menus to donors only', function () {
    $donatur = User::factory()->create(['role' => 'donatur', 'status' => 'aktif']);

    $this->actingAs($donatur)
        ->get(route('donatur.dashboard'))
        ->assertOk()
        ->assertSee(['Donasi Baru', 'Riwayat Donasi', 'Profil Saya'])
        ->assertDontSee(['Data User', 'Data Anak Asuh', 'Data Kegiatan']);
});
