<?php

use App\Http\Controllers\Bendahara\DashboardController;
use App\Http\Controllers\Bendahara\DonasiController;
use App\Http\Controllers\Bendahara\KeuanganController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Donasi
    Route::patch('/donasi/{donasi}/validasi', [DonasiController::class, 'validasi'])->name('donasi.validasi');
    Route::patch('/donasi/{donasi}/tolak', [DonasiController::class, 'tolak'])->name('donasi.tolak');
    Route::resource('donasi', DonasiController::class);
    // Keuangan
    Route::resource('keuangan', KeuanganController::class)->except(['show']);
    
    // Laporan Bulanan
    Route::get('/laporan-bulanan', [\App\Http\Controllers\Bendahara\LaporanKeuanganBulananController::class, 'index'])->name('laporan-bulanan.index');
    Route::get('/laporan-bulanan/{laporan}/cetak', [\App\Http\Controllers\Bendahara\LaporanKeuanganBulananController::class, 'cetak'])->name('laporan-bulanan.cetak');
    Route::post('/laporan-bulanan/{laporan}/submit', [\App\Http\Controllers\Bendahara\LaporanKeuanganBulananController::class, 'submit'])->name('laporan-bulanan.submit');
});
