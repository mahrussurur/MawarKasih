<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnakAsuhController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\DonasiController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')
    ->middleware(['auth', 'role:admin', \App\Http\Middleware\AdminSessionTimeout::class])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Anak Asuh - tambahkan route cetak sebelum resource
        // agar tidak tertimpa oleh route resource {anak_asuh}
        Route::get('/anak-asuh/cetak', [AnakAsuhController::class, 'cetak'])->name('anak-asuh.cetak');
        Route::resource('anak-asuh', AnakAsuhController::class);
        // User (Pengganti Pengasuh & Donatur)
        Route::get('/users/cetak', [UserController::class, 'cetak'])->name('users.cetak');
        Route::resource('users', UserController::class);
        // Donasi - route cetak & aksi khusus didahulukan agar tidak tertimpa wildcard {donasi}
        Route::get('donasi/cetak', [DonasiController::class, 'cetak'])->name('donasi.cetak');
        Route::patch('donasi/{donasi}/validasi', [DonasiController::class, 'validasi'])->name('donasi.validasi');
        Route::patch('donasi/{donasi}/tolak', [DonasiController::class, 'tolak'])->name('donasi.tolak');
        Route::resource('donasi', DonasiController::class);

        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('galeri',  GaleriController::class);
        
        // ── ROUTE PUBLIK (di luar middleware auth) ──
        // Cek status donasi untuk donatur via kode_donasi
        Route::get('cek-donasi', [DonasiController::class, 'cekStatus'])->name('donasi.cek');
 

    });