<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bendahara\DashboardController;

Route::middleware(['auth', 'role:bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Donasi management for Bendahara
    Route::get('/donasi/cetak', [\App\Http\Controllers\Bendahara\DonasiController::class, 'cetak'])->name('donasi.cetak');
    Route::patch('/donasi/{donasi}/validasi', [\App\Http\Controllers\Bendahara\DonasiController::class, 'validasi'])->name('donasi.validasi');
    Route::patch('/donasi/{donasi}/tolak', [\App\Http\Controllers\Bendahara\DonasiController::class, 'tolak'])->name('donasi.tolak');
    Route::resource('donasi', \App\Http\Controllers\Bendahara\DonasiController::class)->only(['index', 'show']);
    // Transaksi Keuangan
    Route::resource('transaksi', \App\Http\Controllers\Bendahara\TransaksiController::class)->except(['show']);
});
