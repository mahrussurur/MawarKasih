<?php
// =========================================================================
// STUB CONTROLLERS — App\Http\Controllers\Public\
// Semua controller di bawah ini adalah stub yang perlu dilengkapi.
// Pisahkan masing-masing ke file PHP tersendiri sesuai nama class-nya.
// =========================================================================

// ---------------------------------------------------------------------
// File: app/Http/Controllers/Public/KegiatanPublicController.php
// ---------------------------------------------------------------------
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan; // Model dikelola Admin\KegiatanController

class KegiatanPublicController extends Controller
{
    /**
     * Daftar semua kegiatan (paginate).
     * View   : resources/views/public/pages/kegiatan/index.blade.php
     * Route  : GET /kegiatan  →  route('public.kegiatan')
     */
    public function index()
    {
        return view('public.pages.kegiatan.index', [
            // 12 kegiatan per halaman, urutkan terbaru
            'kegiatans'    => Kegiatan::latest('tanggal')->paginate(12),
            // Daftar kategori untuk filter (ambil nilai unik dari kolom kategori)
            'kategoriList' => Kegiatan::select('kategori')->distinct()->pluck('kategori'),
        ]);
    }

    /**
     * Detail satu kegiatan.
     * View   : resources/views/public/pages/kegiatan/show.blade.php
     * Route  : GET /kegiatan/{id}  →  route('public.kegiatan.show', $id)
     */
    public function show($id)
    {
        return view('public.pages.kegiatan.show', [
            'kegiatan' => Kegiatan::findOrFail($id),
        ]);
    }
}

// ---------------------------------------------------------------------
// File: app/Http/Controllers/Public/GaleriPublicController.php
// ---------------------------------------------------------------------
// namespace App\Http\Controllers\Public;
// use App\Models\Galeri; // Model dikelola Admin\GaleriController
//
// class GaleriPublicController extends Controller
// {
//     /** View: resources/views/public/pages/galeri.blade.php */
//     public function index()
//     {
//         return view('public.pages.galeri', [
//             'galeris' => Galeri::latest()->paginate(16),
//         ]);
//     }
// }

// ---------------------------------------------------------------------
// File: app/Http/Controllers/Public/DonasiPublicController.php
// ---------------------------------------------------------------------
// namespace App\Http\Controllers\Public;
// use App\Models\Donasi; // Model dikelola Admin\DonasiController
//
// class DonasiPublicController extends Controller
// {
//     /** View: resources/views/public/pages/donasi/index.blade.php */
//     public function index()
//     {
//         return view('public.pages.donasi.index');
//     }
//
//     /** Simpan donasi baru yang dikirim lewat form publik */
//     public function store(Request $request)
//     {
//         // TODO: validasi & simpan ke tabel donasi
//     }
// }

// ---------------------------------------------------------------------
// File: app/Http/Controllers/Public/ProfilOrfanatController.php
// ---------------------------------------------------------------------
// namespace App\Http\Controllers\Public;
// use App\Models\Pengasuh; // Model dikelola Admin\PengasuhController
//
// class ProfilOrfanatController extends Controller
// {
//     /** View: resources/views/public/pages/tentang.blade.php */
//     public function index()
//     {
//         return view('public.pages.tentang', [
//             // Tampilkan daftar pengasuh di halaman tentang kami
//             'pengasuh' => Pengasuh::all(),
//         ]);
//     }
// }