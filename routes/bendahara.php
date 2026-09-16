<?php

use App\Http\Controllers\Bendahara\DashboardController;
use App\Http\Controllers\Bendahara\DonasiController;
use App\Http\Controllers\Bendahara\KeuanganController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Donasi
    Route::get('/donasi/cetak', [DonasiController::class, 'cetak'])->name('donasi.cetak');
    Route::patch('/donasi/{donasi}/validasi', [DonasiController::class, 'validasi'])->name('donasi.validasi');
    Route::patch('/donasi/{donasi}/tolak', [DonasiController::class, 'tolak'])->name('donasi.tolak');
    Route::resource('donasi', DonasiController::class);
    // Keuangan
    Route::get('/keuangan/cetak', [KeuanganController::class, 'cetak'])->name('keuangan.cetak');
    Route::resource('keuangan', KeuanganController::class)->except(['show']);
});
