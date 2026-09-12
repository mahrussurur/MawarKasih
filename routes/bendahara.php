<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bendahara\DashboardController;

Route::middleware(['auth', 'role:bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
