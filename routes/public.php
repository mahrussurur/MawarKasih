<?php

use App\Http\Controllers\Public\BerandaController;
use App\Http\Controllers\Public\KegiatanPublicController;
use App\Http\Controllers\Public\DonasiPublicController;
use App\Http\Controllers\Public\GaleriPublicController;
use App\Http\Controllers\Public\TentangController;

Route::prefix('')->name('public.')->group(function () {

    // ── Beranda ─────────────────────────────────────────────
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/home', fn() => redirect()->route('public.beranda'))->name('home');

    // ── Kegiatan ────────────────────────────────────────────
    Route::get('/kegiatan', [KegiatanPublicController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/{id}', [KegiatanPublicController::class, 'show'])->name('kegiatan.show');

    // ── Donasi ──────────────────────────────────────────────
    Route::get('/donasi', [DonasiPublicController::class, 'form'])->name('donasi.form');
    Route::get('/donasi/rekening', [DonasiPublicController::class, 'rekening'])->name('donasi.rekening');
    Route::get('/donasi/tutorial', [DonasiPublicController::class, 'tutorial'])->name('donasi.tutorial');
    Route::get('/donasi/validasi/{kode_donasi?}', [DonasiPublicController::class, 'validasi'])->name('donasi.validasi');
    Route::get('/donasi/validasi/{kode_donasi}/upload', fn($kode_donasi) => redirect()->route('public.donasi.validasi', ['kode_donasi' => $kode_donasi]));
    Route::post('/donasi/validasi/{kode_donasi}/upload', [DonasiPublicController::class, 'uploadBukti'])->name('donasi.validasi.upload');
    Route::get('/donasi/kirim', fn() => redirect()->route('public.donasi.form'));
    Route::post('/donasi/kirim', [DonasiPublicController::class, 'kirim'])->name('donasi.kirim');
    Route::get('/donasi/reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('donasi.password.reset');

    // ── Tentang Kami ─────────────────────────────────────────
    Route::get('/tentang/profil', [TentangController::class, 'profil'])->name('tentang.profil');
    Route::get('/tentang/visi-misi', [TentangController::class, 'visiMisi'])->name('tentang.visi-misi');

    // ── Galeri ───────────────────────────────────────────────
    Route::get('/galeri', [GaleriPublicController::class, 'index'])->name('galeri.index');
    
    // ── Kontak ───────────────────────────────────────────────
    Route::get('/kontak', [TentangController::class, 'kontak'])->name('kontak');

});