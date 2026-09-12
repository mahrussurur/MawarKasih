<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengasuh\DashboardController;

Route::middleware(['auth', 'role:pengasuh'])->prefix('pengasuh')->name('pengasuh.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
