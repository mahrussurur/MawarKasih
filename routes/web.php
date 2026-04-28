<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; //ridho
use App\Http\Controllers\AnakAsuhController; //alfan
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/anak-asuh', [AnakAsuhController::class, 'index'])->name('anak-asuh.index');
    Route::get('/anak-asuh/create', [AnakAsuhController::class, 'create'])->name('anak-asuh.create');
    Route::post('/anak-asuh', [AnakAsuhController::class, 'store'])->name('anak-asuh.store');
    Route::get('/anak-asuh/cetak', [AnakAsuhController::class, 'cetak'])->name('anak-asuh.cetak');
    Route::resource('anak-asuh', AnakAsuhController::class);
});

// --- Grup Route yang perlu Login ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Route Lupa Password ---
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');



/*
|--------------------------------------------------------------------------
| Web Routes - Panti Asuhan Mawar Kasih
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// ── DASHBOARD ──
// Semua route di dalam group ini hanya bisa diakses setelah login (middleware auth)
Route::middleware(['auth'])->group(function () {

    // Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Placeholder routes (aktifkan satu per satu saat membuat fitur) ──
    // Data Anak Asuh
    Route::resource('anak-asuh', \App\Http\Controllers\AnakAsuhController::class);
    // Data Pengasuh
    Route::resource('pengasuh', \App\Http\Controllers\PengasuhController::class);
    // Data Donasi
    Route::resource('donasi', \App\Http\Controllers\DonasiController::class);
    // Data Kegiatan
    Route::resource('kegiatan', \App\Http\Controllers\KegiatanController::class);
    // Galeri Foto
    Route::resource('galeri', \App\Http\Controllers\GaleriController::class);

    Route::get('/anak-asuh/cetak', [AnakAsuhController::class, 'cetak'])->name('anak-asuh.cetak');
    Route::resource('anak-asuh', AnakAsuhController::class);

    Route::get('/anak-asuh/create', [AnakAsuhController::class, 'create'])->name('anak-asuh.create');
    Route::resource('anak-asuh', AnakAsuhController::class);
});

require __DIR__.'/auth.php';