<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Halaman login (GET) - tampilkan form
Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

// Proses login (POST) - submit form
Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

// Proses logout (POST)
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');