<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('public.home');
});

Route::get('/dashboard', function () {
    session()->reflash();
    $role = auth()->user()->role;
    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'ketua' => redirect()->route('ketua.dashboard'),
        'bendahara' => redirect()->route('bendahara.dashboard'),
        'donatur' => redirect()->route('donatur.dashboard'),
        default => redirect('/'),
    };
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [\App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.update');
});

// Load role-specific routes
require __DIR__ . '/bendahara.php';
require __DIR__ . '/ketua.php';
require __DIR__ . '/donatur.php';

// Load route admin (panel pengelolaan data)
require __DIR__ . '/admin.php';

// Load route web profile publik
require __DIR__ . '/public.php';

// Load route autentikasi bawaan Laravel (login, register, dsb.)
require __DIR__ . '/auth.php';