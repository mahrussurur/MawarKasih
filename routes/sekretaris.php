<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sekretaris\DashboardController;

Route::middleware(['auth', 'role:sekretaris'])->prefix('sekretaris')->name('sekretaris.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/kegiatan/cetak', [\App\Http\Controllers\Sekretaris\KegiatanController::class, 'cetak'])->name('kegiatan.cetak');
    Route::resource('kegiatan', \App\Http\Controllers\Sekretaris\KegiatanController::class);
    Route::resource('galeri', \App\Http\Controllers\Sekretaris\GaleriController::class);

    // Data Anak Asuh
    Route::get('/anak-asuh/cetak', [\App\Http\Controllers\Sekretaris\AnakAsuhController::class, 'cetak'])->name('anak-asuh.cetak');
    Route::get('/anak-asuh', [\App\Http\Controllers\Sekretaris\AnakAsuhController::class, 'index'])->name('anak-asuh.index');
    Route::get('/anak-asuh/{anakAsuh}', [\App\Http\Controllers\Sekretaris\AnakAsuhController::class, 'show'])->name('anak-asuh.show');

    // Data Pengelola
    Route::prefix('pengelola/{roleFilter}')->name('pengelola.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Sekretaris\PengelolaController::class, 'index'])->name('index');
        Route::get('/{user}', [\App\Http\Controllers\Sekretaris\PengelolaController::class, 'show'])->name('show');
    });

    // Data Donasi
    Route::get('/donasi/cetak', [\App\Http\Controllers\Sekretaris\DonasiController::class, 'cetak'])->name('donasi.cetak');
    Route::get('/donasi', [\App\Http\Controllers\Sekretaris\DonasiController::class, 'index'])->name('donasi.index');
    Route::get('/donasi/{donasi}', [\App\Http\Controllers\Sekretaris\DonasiController::class, 'show'])->name('donasi.show');

    // Data Keuangan
    Route::get('/keuangan/cetak', [\App\Http\Controllers\Sekretaris\KeuanganController::class, 'cetak'])->name('keuangan.cetak');
    Route::get('/keuangan', [\App\Http\Controllers\Sekretaris\KeuanganController::class, 'index'])->name('keuangan.index');
});
