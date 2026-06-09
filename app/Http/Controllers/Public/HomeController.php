<?php
/**
 * ============================================================
 * HOME CONTROLLER
 * app/Http/Controllers/Public/HomeController.php
 * ============================================================
 * Controller untuk halaman beranda publik.
 *
 * DATA YANG DIKIRIM KE VIEW:
 * - $stats          : Array angka statistik (dari model masing-masing)
 * - $kegiatans      : Collection semua kegiatan yang dikelola admin
 *
 * CARA PAKAI:
 * Buat folder: app/Http/Controllers/Public/
 * Simpan file ini sebagai HomeController.php
 * ============================================================
 */

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// ============================================================
// IMPORT MODEL
// Sesuaikan namespace model dengan struktur project Anda.
// Contoh: use App\Models\AnakAsuh;
// ============================================================
use App\Models\AnakAsuh;   // Model tabel anak_asuhs
use App\Models\Pengasuh;   // Model tabel penguruses
use App\Models\Kegiatan;   // Model tabel kegiatans
use App\Models\Donatur;   // Model tabel donaturs
use App\Models\Galeri;    // Model tabel galeris

class HomeController extends Controller
{
    /**
     * Tampilkan halaman beranda publik.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ======================================================
        // STATISTIK
        // Sesuaikan query dengan struktur tabel Anda.
        // Contoh: jika kolom status anak asuh bernama 'status_aktif',
        //         ubah where('status', 'aktif') sesuai nama kolom.
        // ======================================================
        $stats = [
            'totalAnakAsuh'  => AnakAsuh::count(),
            'totalPengasuh'  => Pengasuh::count(),
            'totalKegiatan'  => Kegiatan::count(),
            'totalDonatur'  => Donatur::count(),
        ];

        // ======================================================
        // DAFTAR KEGIATAN
        // Ambil semua kegiatan yang ada di admin.
        // Urutkan berdasarkan tanggal pelaksanaan paling terbaru.
        //
        // Field yang diakses di view:
        // - id, judul, tanggal_pelaksanaan, gambar, deskripsi_singkat, kategori
        // ======================================================

        $kegiatans = Kegiatan::latest('tanggal_pelaksanaan')
            ->get();

        $fasilitas = Galeri::where('kategori', 'fasilitas')->latest()->get();

        return view('public.home', compact('stats', 'kegiatans', 'fasilitas'));
    }
}