<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sekretaris\DashboardController;

Route::middleware(['auth', 'role:sekretaris'])->prefix('sekretaris')->name('sekretaris.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Data Kegiatan (read-only)
    Route::get('/kegiatan', [\App\Http\Controllers\Sekretaris\KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/{kegiatan}', [\App\Http\Controllers\Sekretaris\KegiatanController::class, 'show'])->name('kegiatan.show');

    // Data Galeri (read-only)
    Route::get('/galeri', [\App\Http\Controllers\Sekretaris\GaleriController::class, 'index'])->name('galeri.index');
    Route::get('/galeri/{galeri}', [\App\Http\Controllers\Sekretaris\GaleriController::class, 'show'])->name('galeri.show');

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

    // Laporan Bulanan
    Route::get('laporan-bulanan', [\App\Http\Controllers\Sekretaris\LaporanKeuanganBulananController::class, 'index'])->name('laporan-bulanan.index');
    Route::get('laporan-bulanan/{laporan}/cetak', [\App\Http\Controllers\Sekretaris\LaporanKeuanganBulananController::class, 'cetak'])->name('laporan-bulanan.cetak');
    Route::get('laporan-bulanan/{laporan}', [\App\Http\Controllers\Sekretaris\LaporanKeuanganBulananController::class, 'show'])->name('laporan-bulanan.show');


    // Data Alumni (read-only)
    Route::get('/alumni/cetak', [\App\Http\Controllers\Sekretaris\AlumniController::class, 'cetak'])->name('alumni.cetak');
    Route::get('/alumni', [\App\Http\Controllers\Sekretaris\AlumniController::class, 'index'])->name('alumni.index');
    Route::get('/alumni/{alumni}', [\App\Http\Controllers\Sekretaris\AlumniController::class, 'show'])->name('alumni.show');
});
