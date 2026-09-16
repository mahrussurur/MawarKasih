<?php
/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES - Website Publik Panti Asuhan Mawar Kasih
|--------------------------------------------------------------------------
| Semua route halaman publik (tidak perlu login)
| Controller ada di App\Http\Controllers\Public\
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\KegiatanPublicController;
use App\Http\Controllers\Public\DonasiPublicController;
use App\Http\Controllers\Public\GaleriPublicController;
use App\Http\Controllers\Public\TentangController;

Route::prefix('')->name('public.')->group(function () {

    // ── Beranda ─────────────────────────────────────────────
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ── Kegiatan ────────────────────────────────────────────
    Route::get('/kegiatan', [KegiatanPublicController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/{id}', [KegiatanPublicController::class, 'show'])->name('kegiatan.show');

    // ── Donasi ──────────────────────────────────────────────
    Route::get('/donasi', [DonasiPublicController::class, 'form'])->name('donasi.form');
    Route::get('/donasi/rekening', [DonasiPublicController::class, 'rekening'])->name('donasi.rekening');
    Route::get('/donasi/tutorial', [DonasiPublicController::class, 'tutorial'])->name('donasi.tutorial');
    Route::get('/donasi/validasi/{kode_donasi?}', [DonasiPublicController::class, 'validasi'])->name('donasi.validasi');
    Route::post('/donasi/validasi/{kode_donasi}/upload', [DonasiPublicController::class, 'uploadBukti'])->name('donasi.validasi.upload');
    Route::post('/donasi/kirim', [DonasiPublicController::class, 'kirim'])->name('donasi.kirim');

    // ── Tentang Kami ─────────────────────────────────────────
    Route::get('/tentang/profil', [TentangController::class, 'profil'])->name('tentang.profil');
    Route::get('/tentang/visi-misi', [TentangController::class, 'visiMisi'])->name('tentang.visi-misi');

    // ── Galeri ───────────────────────────────────────────────
    Route::get('/galeri', [GaleriPublicController::class, 'index'])->name('galeri.index');
    Route::get('/galeri/{id}', [GaleriPublicController::class, 'show'])->name('galeri.show');
    
    // ── Kontak ───────────────────────────────────────────────
    Route::get('/kontak', [TentangController::class, 'kontak'])->name('kontak');

    // ── Legal ────────────────────────────────────────────────
    Route::get('/kebijakan-privasi', fn() => view('public.pages.kebijakan'))->name('kebijakan');
    Route::get('/syarat-ketentuan', fn() => view('public.pages.syarat'))->name('syarat');

});