<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Entry Point
|--------------------------------------------------------------------------
| File ini hanya sebagai pintu masuk. Semua route dipecah ke:
|   - routes/admin.php   → panel admin (butuh login)
|   - routes/public_web.php → web profile (bisa diakses semua)
|   - routes/auth.php    → login, register (bawaan Laravel)
*/

// Redirect root ke halaman utama web profile
Route::get('/', function () {
    return redirect()->route('login');
});

// Load route admin (panel pengelolaan data)
require __DIR__ . '/admin.php';

// Load route web profile publik
require __DIR__ . '/public.php';

// Load route autentikasi bawaan Laravel (login, register, dsb.)
require __DIR__ . '/auth.php';