<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnakAsuhController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\DonasiController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KeuanganController;
use App\Http\Controllers\Admin\ArsipDokumenController;

Route::prefix('admin')
    ->middleware(['auth', 'role:admin', \App\Http\Middleware\AdminSessionTimeout::class])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Anak Asuh - tambahkan route cetak sebelum resource
        // agar tidak tertimpa oleh route resource {anak_asuh}
        Route::get('/anak-asuh/cetak', [AnakAsuhController::class, 'cetak'])->name('anak-asuh.cetak');
        Route::resource('anak-asuh', AnakAsuhController::class)->except(['destroy']);

        // Alumni
        Route::get('/anak-asuh/{anak_asuh_id}/jadikan-alumni', [AlumniController::class, 'create'])->name('alumni.create');
        Route::post('/anak-asuh/{anak_asuh_id}/jadikan-alumni', [AlumniController::class, 'store'])->name('alumni.store');
        Route::resource('alumni', AlumniController::class)->except(['create', 'store', 'destroy'])->parameters(['alumni' => 'alumni']);

        // Manajemen akun login; profil dikelola dari menu Data Yayasan.
        Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        // Donasi - route aksi khusus didahulukan agar tidak tertimpa wildcard {donasi}
        Route::patch('donasi/{donasi}/validasi', [DonasiController::class, 'validasi'])->name('donasi.validasi');
        Route::patch('donasi/{donasi}/tolak', [DonasiController::class, 'tolak'])->name('donasi.tolak');
        Route::resource('donasi', DonasiController::class);
        Route::resource('keuangan', KeuanganController::class)->parameters([
            'keuangan' => 'transaksi',
        ])->only(['index'])->names([
            'index'   => 'admin.keuangan.index',
        ]);

        // Laporan Bulanan (Review)
        Route::get('laporan-bulanan', [\App\Http\Controllers\Admin\LaporanKeuanganBulananController::class, 'index'])->name('admin.laporan-bulanan.index');
        Route::get('laporan-bulanan/{laporan}/cetak', [\App\Http\Controllers\Admin\LaporanKeuanganBulananController::class, 'cetak'])->name('admin.laporan-bulanan.cetak');
        Route::get('laporan-bulanan/{laporan}', [\App\Http\Controllers\Admin\LaporanKeuanganBulananController::class, 'show'])->name('admin.laporan-bulanan.show');

        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('galeri',  GaleriController::class);

        // Data Pegawai (Admin, Ketua, Bendahara, Pengasuh)
        Route::resource('pegawai', \App\Http\Controllers\Admin\PegawaiController::class)->names('admin.pegawai');

        // Data Donatur
        Route::resource('donatur', \App\Http\Controllers\Admin\DonaturController::class)->names('admin.donatur');

        // Arsip Dokumen Administrasi
        Route::get('arsip-dokumen/{arsip}/download', [ArsipDokumenController::class, 'download'])->name('admin.arsip-dokumen.download');
        Route::resource('arsip-dokumen', ArsipDokumenController::class)->parameters([
            'arsip-dokumen' => 'arsip',
        ])->names('admin.arsip-dokumen');
    });

