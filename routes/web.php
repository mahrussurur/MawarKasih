<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnakAsuhController; // Sudah dikumpulkan di atas
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

    // Route Anak Asuh
    Route::get('/anak-asuh', [AnakAsuhController::class, 'index'])->name('anak-asuh.index');
});

// --- Route Lupa Password ---
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

require __DIR__.'/auth.php';