<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengasuh\DashboardController;

Route::middleware(['auth', 'role:pengasuh'])->prefix('pengasuh')->name('pengasuh.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('anak-asuh', \App\Http\Controllers\Pengasuh\AnakAsuhController::class);

    // Alumni
    Route::get('/alumni', [\App\Http\Controllers\Pengasuh\AlumniController::class, 'index'])->name('alumni.index');
    Route::get('/alumni/{alumni}', [\App\Http\Controllers\Pengasuh\AlumniController::class, 'show'])->name('alumni.show');
    Route::get('/alumni/{alumni}/edit', [\App\Http\Controllers\Pengasuh\AlumniController::class, 'edit'])->name('alumni.edit');
    Route::put('/alumni/{alumni}', [\App\Http\Controllers\Pengasuh\AlumniController::class, 'update'])->name('alumni.update');
    Route::get('/anak-asuh/{anak_asuh_id}/jadikan-alumni', [\App\Http\Controllers\Pengasuh\AlumniController::class, 'create'])->name('alumni.create');
    Route::post('/anak-asuh/{anak_asuh_id}/jadikan-alumni', [\App\Http\Controllers\Pengasuh\AlumniController::class, 'store'])->name('alumni.store');
});

