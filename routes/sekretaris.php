<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sekretaris\DashboardController;

Route::middleware(['auth', 'role:sekretaris'])->prefix('sekretaris')->name('sekretaris.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
