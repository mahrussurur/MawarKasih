<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AnakAsuhController;
use App\Http\Controllers\Admin\KegiatanController;
use App\Http\Controllers\Admin\DonasiController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PengelolaController;
use App\Http\Controllers\Admin\KeuanganController;

Route::prefix('admin')
    ->middleware(['auth', 'role:admin', \App\Http\Middleware\AdminSessionTimeout::class])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Anak Asuh - tambahkan route cetak sebelum resource
        // agar tidak tertimpa oleh route resource {anak_asuh}
        Route::get('/anak-asuh/cetak', [AnakAsuhController::class, 'cetak'])->name('anak-asuh.cetak');
        Route::resource('anak-asuh', AnakAsuhController::class);
        // Manajemen akun login; profil dikelola dari menu Data Yayasan.
        Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        // Donasi - route cetak & aksi khusus didahulukan agar tidak tertimpa wildcard {donasi}
        Route::get('donasi/cetak', [DonasiController::class, 'cetak'])->name('donasi.cetak');
        Route::patch('donasi/{donasi}/validasi', [DonasiController::class, 'validasi'])->name('donasi.validasi');
        Route::patch('donasi/{donasi}/tolak', [DonasiController::class, 'tolak'])->name('donasi.tolak');
        Route::resource('donasi', DonasiController::class);
        Route::get('keuangan/cetak', [KeuanganController::class, 'cetak'])->name('admin.keuangan.cetak');
        Route::resource('keuangan', KeuanganController::class)->parameters([
            'keuangan' => 'transaksi',
        ])->except(['show'])->names([
            'index'   => 'admin.keuangan.index',
            'create'  => 'admin.keuangan.create',
            'store'   => 'admin.keuangan.store',
            'edit'    => 'admin.keuangan.edit',
            'update'  => 'admin.keuangan.update',
            'destroy' => 'admin.keuangan.destroy',
        ]);

        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('galeri',  GaleriController::class);

        // Data Pengelola (filter role; sumber data users + profil_pengelola)
        Route::prefix('data/{roleFilter}')->name('admin.pengelola.')->group(function () {
            Route::get('/', [PengelolaController::class, 'index'])->name('index');
            Route::get('/create', [PengelolaController::class, 'create'])->name('create');
            Route::post('/', [PengelolaController::class, 'store'])->name('store');
            Route::get('/{user}', [PengelolaController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [PengelolaController::class, 'edit'])->name('edit');
            Route::patch('/{user}', [PengelolaController::class, 'update'])->name('update');
            Route::delete('/{user}', [PengelolaController::class, 'destroy'])->name('destroy');

        });

        // ── ROUTE PUBLIK (di luar middleware auth) ──
        // Cek status donasi untuk donatur via kode_donasi
        Route::get('cek-donasi', [DonasiController::class, 'cekStatus'])->name('donasi.cek');

    });
