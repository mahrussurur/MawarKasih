<?php

use App\Http\Controllers\Ketua\AlumniController;
use App\Http\Controllers\Ketua\AnakAsuhController;
use App\Http\Controllers\Ketua\ArsipDokumenController;
use App\Http\Controllers\Ketua\DashboardController;
use App\Http\Controllers\Ketua\DonaturController;
use App\Http\Controllers\Ketua\LaporanKeuanganBulananController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:ketua'])->prefix('ketua')->name('ketua.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Donatur (read-only)
    Route::get('/donatur', [DonaturController::class, 'index'])->name('donatur.index');
    Route::get('/donatur/{user}', [DonaturController::class, 'show'])->name('donatur.show');

    // Data Anak Asuh (read-only)
    Route::get('/anak-asuh', [AnakAsuhController::class, 'index'])->name('anak-asuh.index');
    Route::get('/anak-asuh/{anakAsuh}', [AnakAsuhController::class, 'show'])->name('anak-asuh.show');

    // Data Alumni (read-only)
    Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
    Route::get('/alumni/{alumni}', [AlumniController::class, 'show'])->name('alumni.show');

    // Arsip Dokumen Administrasi (read-only & download)
    Route::get('/arsip-dokumen', [ArsipDokumenController::class, 'index'])->name('arsip-dokumen.index');
    Route::get('/arsip-dokumen/{arsip}', [ArsipDokumenController::class, 'show'])->name('arsip-dokumen.show');
    Route::get('/arsip-dokumen/{arsip}/download', [ArsipDokumenController::class, 'download'])->name('arsip-dokumen.download');

    // Laporan Bulanan (Review dan Approval)
    Route::get('/laporan-bulanan', [LaporanKeuanganBulananController::class, 'index'])->name('laporan-bulanan.index');
    Route::get('/laporan-bulanan/{laporan}/cetak', [LaporanKeuanganBulananController::class, 'cetak'])->name('laporan-bulanan.cetak');
    Route::get('/laporan-bulanan/{laporan}', [LaporanKeuanganBulananController::class, 'show'])->name('laporan-bulanan.show');
    Route::post('/laporan-bulanan/{laporan}/approve', [LaporanKeuanganBulananController::class, 'approve'])->name('laporan-bulanan.approve');
    Route::post('/laporan-bulanan/{laporan}/return', [LaporanKeuanganBulananController::class, 'return'])->name('laporan-bulanan.return');
});
