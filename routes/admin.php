<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnakAsuhController;
use App\Http\Controllers\Admin\PengasuhController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\DonasiController;
use App\Http\Controllers\Admin\DonaturController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\ProfileController;

Route::prefix('admin')
    ->middleware(['auth', \App\Http\Middleware\AdminSessionTimeout::class])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Anak Asuh - tambahkan route cetak sebelum resource
        // agar tidak tertimpa oleh route resource {anak_asuh}
        Route::get('/anak-asuh/cetak', [AnakAsuhController::class, 'cetak'])->name('anak-asuh.cetak');
        Route::resource('anak-asuh', AnakAsuhController::class);

        // Pengasuh - sama, route cetak didahulukan
        Route::get('/pengasuh/cetak', [PengasuhController::class, 'cetak'])->name('pengasuh.cetak');
        Route::resource('pengasuh', PengasuhController::class);

        // Donatur - route cetak didahulukan
        Route::get('/donatur/cetak', [DonaturController::class, 'cetak'])->name('donatur.cetak');
        Route::resource('donatur', DonaturController::class);

        // Resource lainnya
        Route::resource('donasi',  DonasiController::class);
        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('galeri',  GaleriController::class);

        // Cetak laporan donasi valid (PDF)
        Route::get('donasi/cetak', [DonasiController::class, 'cetak'])->name('donasi.cetak');
        
        // Validasi donasi (pending → valid)
        Route::patch('donasi/{donasi}/validasi', [DonasiController::class, 'validasi'])->name('donasi.validasi');
        
        // Tolak donasi (pending → ditolak)
        Route::patch('donasi/{donasi}/tolak', [DonasiController::class, 'tolak'])->name('donasi.tolak');
        
        // Resource standar (index, create, store, show, edit, update, destroy)
        Route::resource('donasi', DonasiController::class);
        
        // ── ROUTE PUBLIK (di luar middleware auth) ──
        // Cek status donasi untuk donatur via kode_donasi
        Route::get('cek-donasi', [DonasiController::class, 'cekStatus'])->name('donasi.cek');
 

        // Profile pengguna yang sedang login
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });