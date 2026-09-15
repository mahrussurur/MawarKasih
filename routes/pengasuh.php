<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengasuh\DashboardController;

Route::middleware(['auth', 'role:pengasuh'])->prefix('pengasuh')->name('pengasuh.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/anak-asuh/cetak', [\App\Http\Controllers\Pengasuh\AnakAsuhController::class, 'cetak'])->name('anak-asuh.cetak');
    Route::resource('anak-asuh', \App\Http\Controllers\Pengasuh\AnakAsuhController::class);

    Route::resource('catatan-perkembangan', \App\Http\Controllers\Pengasuh\CatatanPerkembanganController::class);
});

