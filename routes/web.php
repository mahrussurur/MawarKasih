<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; //ridho
use App\Http\Controllers\AnakAsuhController; //alfan
use App\Http\Controllers\PengasuhController; //aca
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// --- Grup Route yang perlu Login ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/anak-asuh/cetak', [AnakAsuhController::class, 'cetak'])->name('anak-asuh.cetak');
    Route::get('/pengasuh/cetak', [PengasuhController::class, 'cetak'])->name('pengasuh.cetak');
    Route::resource('anak-asuh', AnakAsuhController::class);
    Route::resource('pengasuh', PengasuhController::class);
    Route::resource('donasi', \App\Http\Controllers\DonasiController::class);
    Route::resource('kegiatan', \App\Http\Controllers\KegiatanController::class);
    Route::resource('galeri', \App\Http\Controllers\GaleriController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Route Lupa Password ---
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

require __DIR__.'/auth.php';