<!-- {{--
    ============================================================
    REFERENSI ROUTES - routes/web.php (bagian publik)
    ============================================================
    Tambahkan route berikut ke file routes/web.php Anda.
    Semua route publik dikelompokkan dalam prefix 'public.'.

    CARA PAKAI:
    Salin blok Route::group di bawah dan tempel ke web.php Anda.
    ============================================================
--}}

{{-- ========================================================
     TAMBAHKAN INI KE routes/web.php
     ======================================================== --}} -->

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
use App\Http\Controllers\Public\KegiatanController;
use App\Http\Controllers\Public\DonasiController;
use App\Http\Controllers\Public\TentangController;
use App\Http\Controllers\Public\FasilitasController;

Route::prefix('')->name('public.')->group(function () {

    // ── Beranda ─────────────────────────────────────────────
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ── Kegiatan ────────────────────────────────────────────
    Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/{id}', [KegiatanController::class, 'show'])->name('kegiatan.show');

    // ── Donasi ──────────────────────────────────────────────
    Route::get('/donasi', [DonasiController::class, 'form'])->name('donasi.form');
    Route::get('/donasi/rekening', [DonasiController::class, 'rekening'])->name('donasi.rekening');
    Route::get('/donasi/tutorial', [DonasiController::class, 'tutorial'])->name('donasi.tutorial');
    Route::get('/donasi/validasi', [DonasiController::class, 'validasi'])->name('donasi.validasi');
    Route::get('/donasi/registrasi', [DonasiController::class, 'registrasi'])->name('donasi.registrasi');
    Route::post('/donasi/kirim', [DonasiController::class, 'kirim'])->name('donasi.kirim');

    // ── Tentang Kami ─────────────────────────────────────────
    Route::get('/tentang/profil', [TentangController::class, 'profil'])->name('tentang.profil');
    Route::get('/tentang/visi-misi', [TentangController::class, 'visiMisi'])->name('tentang.visi-misi');

    // ── Fasilitas ────────────────────────────────────────────
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas');

    // ── Galeri ───────────────────────────────────────────────
    Route::get('/galeri', [TentangController::class, 'galeri'])->name('galeri');

    // ── Kontak ───────────────────────────────────────────────
    Route::get('/kontak', [TentangController::class, 'kontak'])->name('kontak');

    // ── Legal ────────────────────────────────────────────────
    Route::get('/kebijakan-privasi', fn() => view('public.pages.kebijakan'))->name('kebijakan');
    Route::get('/syarat-ketentuan', fn() => view('public.pages.syarat'))->name('syarat');

});