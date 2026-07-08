<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('public.home');
});

// Load route admin (panel pengelolaan data)
require __DIR__ . '/admin.php';

// Load route web profile publik
require __DIR__ . '/public.php';

// Load route autentikasi bawaan Laravel (login, register, dsb.)
require __DIR__ . '/auth.php';