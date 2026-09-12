<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Donatur\DashboardController;

Route::middleware(['auth', 'role:donatur'])->prefix('donatur')->name('donatur.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
