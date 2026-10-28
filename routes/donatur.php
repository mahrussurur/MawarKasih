<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Donatur\DashboardController;

Route::middleware(['auth', 'role:donatur'])->prefix('donatur')->name('donatur.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/donasi/{id}/upload-bukti', [\App\Http\Controllers\Donatur\DonasiController::class, 'uploadBukti'])->name('donasi.upload-bukti');
    Route::resource('donasi', \App\Http\Controllers\Donatur\DonasiController::class)->only(['index', 'show']);

    // Laporan Keuangan Bulanan
    Route::get('/laporan-bulanan', [\App\Http\Controllers\Donatur\LaporanKeuanganBulananController::class, 'index'])->name('laporan-bulanan.index');
    Route::get('/laporan-bulanan/{laporan}', [\App\Http\Controllers\Donatur\LaporanKeuanganBulananController::class, 'show'])->name('laporan-bulanan.show');
});
