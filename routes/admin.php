<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;   // ridho
use App\Http\Controllers\Admin\AnakAsuhController;    // alfan
use App\Http\Controllers\Admin\PengasuhController;    // aca
use App\Http\Controllers\Admin\KegiatanController;    // mahrus
use App\Http\Controllers\Admin\DonasiController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Semua route di sini hanya bisa diakses setelah login (middleware auth).
| Prefix URL: /admin/...
| Name prefix: (none)
|
| Contoh akses:
|   URL  → /admin/dashboard
|   Name → route('dashboard')
*/

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Anak Asuh - tambahkan route cetak sebelum resource
        // agar tidak tertimpa oleh route resource {anak_asuh}
        Route::get('/anak-asuh/cetak', [AnakAsuhController::class, 'cetak'])
            ->name('anak-asuh.cetak');
        Route::resource('anak-asuh', AnakAsuhController::class);

        // Pengasuh - sama, route cetak didahulukan
        Route::get('/pengasuh/cetak', [PengasuhController::class, 'cetak'])
            ->name('pengasuh.cetak');
        Route::resource('pengasuh', PengasuhController::class);

        // Resource lainnya
        Route::resource('donasi',  DonasiController::class);
        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('galeri',  GaleriController::class);

        // Profile pengguna yang sedang login
        Route::get('/profile',    [ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::patch('/profile',  [ProfileController::class, 'update'])
            ->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');
    });