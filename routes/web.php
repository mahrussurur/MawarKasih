<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('public.home');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'sekretaris' => redirect()->route('sekretaris.dashboard'),
        'bendahara' => redirect()->route('bendahara.dashboard'),
        'pengasuh' => redirect()->route('pengasuh.dashboard'),
        'donatur', 'donatur_tetap' => redirect()->route('donatur.dashboard'),
        default => redirect('/'),
    };
})->middleware('auth')->name('dashboard');

// Load role-specific routes
require __DIR__ . '/bendahara.php';
require __DIR__ . '/sekretaris.php';
require __DIR__ . '/pengasuh.php';
require __DIR__ . '/donatur.php';

// Load route admin (panel pengelolaan data)
require __DIR__ . '/admin.php';

// Load route web profile publik
require __DIR__ . '/public.php';

// Load route autentikasi bawaan Laravel (login, register, dsb.)
require __DIR__ . '/auth.php';