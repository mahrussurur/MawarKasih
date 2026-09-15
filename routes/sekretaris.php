<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sekretaris\DashboardController;

Route::middleware(['auth', 'role:sekretaris'])->prefix('sekretaris')->name('sekretaris.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/kegiatan/cetak', [\App\Http\Controllers\Sekretaris\KegiatanController::class, 'cetak'])->name('kegiatan.cetak');
    Route::resource('kegiatan', \App\Http\Controllers\Sekretaris\KegiatanController::class);
    Route::resource('galeri', \App\Http\Controllers\Sekretaris\GaleriController::class);
});
