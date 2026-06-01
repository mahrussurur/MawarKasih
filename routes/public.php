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
use App\Http\Controllers\Public\DonaturPublicController;
use App\Http\Controllers\Public\GaleriPublicController;
use App\Http\Controllers\Public\TentangController;
use App\Http\Controllers\Public\FasilitasController;

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
    Route::get('/donasi/validasi', [DonasiPublicController::class, 'validasi'])->name('donasi.validasi');
    Route::get('/donasi/login', [DonasiPublicController::class, 'login'])->name('donasi.login');
    Route::post('/donasi/login', [DonasiPublicController::class, 'loginStore'])->name('donasi.login.submit');
    Route::get('/donasi/registrasi', [DonasiPublicController::class, 'registrasi'])->name('donasi.registrasi');
    Route::post('/donasi/registrasi', [DonasiPublicController::class, 'registrasiStore'])->name('donasi.registrasi.submit');
    Route::post('/donasi/kirim', [DonasiPublicController::class, 'kirim'])->name('donasi.kirim');

    Route::get('/profil-donatur', [DonaturPublicController::class, 'profile'])->name('donatur.profile');
    Route::get('/riwayat-donasi', [DonaturPublicController::class, 'history'])->name('donatur.history');
    Route::post('/donatur/logout', [DonaturPublicController::class, 'logout'])->name('donatur.logout');

    // ── Tentang Kami ─────────────────────────────────────────
    Route::get('/tentang/profil', [TentangController::class, 'profil'])->name('tentang.profil');
    Route::get('/tentang/visi-misi', [TentangController::class, 'visiMisi'])->name('tentang.visi-misi');

    // ── Fasilitas ────────────────────────────────────────────
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas');

    // ── Galeri ───────────────────────────────────────────────
    Route::get('/galeri', [GaleriPublicController::class, 'index'])->name('galeri.index');
    Route::get('/galeri/{id}', [GaleriPublicController::class, 'show'])->name('galeri.show');
    // ── Kontak ───────────────────────────────────────────────
    Route::get('/kontak', [TentangController::class, 'kontak'])->name('kontak');

    // ── Legal ────────────────────────────────────────────────
    Route::get('/kebijakan-privasi', fn() => view('public.pages.kebijakan'))->name('kebijakan');
    Route::get('/syarat-ketentuan', fn() => view('public.pages.syarat'))->name('syarat');

});