<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

// Model yang datanya ditampilkan di halaman home
// Semua model ini dikelola oleh admin lewat panel admin
use App\Models\Kegiatan;
use App\Models\AnakAsuh;
use App\Models\Pengasuh;
use App\Models\Donasi;

class HomeController extends Controller
{
    /**
     * Halaman utama / landing page web profile.
     *
     * View   : resources/views/public/pages/home.blade.php
     * Route  : GET /home  →  route('public.home')
     */
    public function index()
    {
        return view('public.pages.home', [
            // 4 kegiatan terbaru — dikelola admin via Admin\KegiatanController
            // Kolom yang dipakai di view: id, nama, deskripsi, tanggal, kategori, foto
            'kegiatanTerbaru' => Kegiatan::latest('tanggal_pelaksanaan')->take(4)->get(),

            // Statistik angka — diambil langsung dari masing-masing model
            'totalAnakAsuh'  => AnakAsuh::count(),
            'totalPengasuh'  => Pengasuh::count(),
            'totalKegiatan'  => Kegiatan::count(),

            // Total donatur unik (berdasarkan nama_donatur atau kolom identifier)
            // Sesuaikan nama kolom dengan migrasi yang sudah ada
            // 'totalDonatur'   => Donasi::distinct('nama_donatur')->count('nama_donatur'),
        ]);
    }
}