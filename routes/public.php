<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\GaleriPublicController;
use App\Http\Controllers\Public\KegiatanPublicController;
use App\Http\Controllers\Public\DonasiPublicController;
use App\Http\Controllers\Public\ProfilOrfanatController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Public Web Routes (Web Profile)
|--------------------------------------------------------------------------
| Semua route di sini bisa diakses tanpa login (guest maupun yang sudah
| login). Ini adalah halaman tampilan publik / web profile organisasi.
|
| Name prefix: public.
|
| Contoh akses:
|   URL  → /
|   Name → route('public.home')
*/

Route::name('public.')->group(function () {

    // Beranda
    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    // Tentang kami / profil panti
    Route::get('/tentang', [ProfilOrfanatController::class, 'index'])
        ->name('tentang');

    // Galeri foto kegiatan
    Route::get('/galeri', [GaleriPublicController::class, 'index'])
        ->name('galeri');

    // Kegiatan
    Route::get('/kegiatan', [KegiatanPublicController::class, 'index'])
        ->name('kegiatan');
    Route::get('/kegiatan/{id}', [KegiatanPublicController::class, 'show'])
        ->name('kegiatan.show');

    // Donasi - halaman info & form donasi publik
    Route::get('/donasi', [DonasiPublicController::class, 'index'])
        ->name('donasi');
    Route::post('/donasi', [DonasiPublicController::class, 'store'])
        ->name('donasi.store');

});

/*
|--------------------------------------------------------------------------
| Forgot Password Routes
|--------------------------------------------------------------------------
| Diletakkan di sini (bukan admin.php) karena tidak butuh login —
| justru diakses saat pengguna BELUM bisa masuk.
*/

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])
    ->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');