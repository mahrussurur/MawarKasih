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
 * - $kegiatanTerbaru: 4 kegiatan terbaru (dari tabel kegiatan)
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
use App\Models\Donasi;    // Model tabel donaturs

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
            'total_donatur'  => Donasi::count(),
        ];

        // ======================================================
        // KEGIATAN TERBARU (4 terbaru)
        // Sesuaikan nama kolom 'tanggal' dengan kolom tanggal
        // di tabel kegiatan Anda (bisa juga 'created_at').
        //
        // Field yang diakses di view:
        // - id, judul, tanggal, gambar, deskripsi_singkat, kategori
        // ======================================================
        $kegiatanTerbaru = Kegiatan::latest('tanggal_pelaksanaan')
            ->take(4)
            ->get();

        return view('public.pages.home', compact('stats', 'kegiatanTerbaru'));
    }
}