<?php

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\ArsipDokumen;
use App\Models\LaporanKeuanganBulanan;
use App\Models\ProfilPegawai;
use App\Models\User;

function createKetuaUser(): User
{
    $ketua = User::factory()->create([
        'role' => 'ketua',
        'status' => 'aktif',
    ]);

    ProfilPegawai::create([
        'user_id' => $ketua->id,
        'nama' => 'Bapak Ketua Panti',
        'jabatan' => 'Ketua Yayasan',
    ]);

    return $ketua;
}

test('guest is redirected to login when accessing ketua dashboard', function () {
    $response = $this->get(route('ketua.dashboard'));

    $response->assertRedirect('/login');
});

test('non-ketua roles cannot access ketua dashboard', function (string $role) {
    $user = User::factory()->create([
        'role' => $role,
        'status' => 'aktif',
    ]);

    $response = $this->actingAs($user)->get(route('ketua.dashboard'));

    $response->assertForbidden();
})->with(['admin', 'bendahara', 'donatur']);

test('ketua can access dashboard successfully and view is loaded with all data', function () {
    $ketua = createKetuaUser();

    // 1. Setup Donatur
    User::factory()->count(3)->create(['role' => 'donatur']);

    // 2. Setup Anak Asuh (2 active, 1 soft deleted)
    $anak1 = AnakAsuh::create([
        'nama' => 'Anak Satu',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '2012-01-01',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
    ]);
    $anak2 = AnakAsuh::create([
        'nama' => 'Anak Dua',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '2013-02-02',
        'jenis_kelamin' => 'P',
        'status_social_anak' => 'Piatu',
    ]);
    $anakDeleted = AnakAsuh::create([
        'nama' => 'Anak Terhapus',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '2014-03-03',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Dhuafa',
    ]);
    $anakDeleted->delete();

    // 3. Setup Alumni
    Alumni::create([
        'anak_asuh_id' => $anak1->id,
        'nama' => 'Alumni Satu',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '2000-01-01',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
        'tanggal_keluar' => '2022-01-01',
    ]);

    // 4. Setup Arsip Dokumen
    ArsipDokumen::create([
        'judul' => 'Akta Yayasan Mawar Kasih',
        'kategori' => 'Legalitas',
        'nomor_dokumen' => 'AKTA-001',
        'file_name_asli' => 'akta.pdf',
        'file_path' => 'arsip/akta.pdf',
        'file_size' => 1048576,
        'mime_type' => 'application/pdf',
        'uploaded_by' => $ketua->id,
    ]);

    // 5. Setup Laporan Keuangan Bulanan
    LaporanKeuanganBulanan::create([
        'tahun' => 2026,
        'bulan' => 5,
        'status' => 'diajukan',
        'saldo_awal' => 5000000,
        'total_pemasukan' => 2500000,
        'total_pengeluaran' => 1500000,
        'saldo_akhir' => 6000000,
        'submitted_by' => $ketua->id,
        'submitted_at' => now(),
    ]);
    LaporanKeuanganBulanan::create([
        'tahun' => 2026,
        'bulan' => 4,
        'status' => 'disetujui',
        'saldo_awal' => 4000000,
        'total_pemasukan' => 2000000,
        'total_pengeluaran' => 1000000,
        'saldo_akhir' => 5000000,
    ]);

    $response = $this->actingAs($ketua)->get(route('ketua.dashboard'));

    $response->assertOk();
    $response->assertViewIs('ketua.dashboard');

    $response->assertViewHas('totalDonatur', 3);
    $response->assertViewHas('totalAnak', 2);
    $response->assertViewHas('totalAlumni', 1);
    $response->assertViewHas('totalArsip', 1);
    $response->assertViewHas('laporanMenungguReview', 1);

    $response->assertViewHas('laporanTerbaru', function ($laporan) {
        return $laporan->count() === 1 && $laporan->first()->status === 'diajukan';
    });

    $response->assertViewHas('arsipTerbaru', function ($arsip) {
        return $arsip->count() === 1 && $arsip->first()->judul === 'Akta Yayasan Mawar Kasih';
    });

    // Cek teks yang dirender di Blade view
    $response->assertSee('Selamat Datang, Bapak Ketua Panti!');
    $response->assertSee('Akta Yayasan Mawar Kasih');
    $response->assertSee('1 Menunggu Tindakan');
});

