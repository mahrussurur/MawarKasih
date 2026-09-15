<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Donatur\DashboardController;

Route::middleware(['auth', 'role:donatur'])->prefix('donatur')->name('donatur.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/donasi/cetak', [\App\Http\Controllers\Donatur\DonasiController::class, 'cetak'])->name('donasi.cetak');
    Route::post('/donasi/{id}/upload-bukti', [\App\Http\Controllers\Donatur\DonasiController::class, 'uploadBukti'])->name('donasi.upload-bukti');
    Route::resource('donasi', \App\Http\Controllers\Donatur\DonasiController::class)->only(['index', 'show']);
});
