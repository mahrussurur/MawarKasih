<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\AnakAsuh;
use App\Models\Pengasuh;
use App\Models\Donasi;
use App\Models\Kegiatan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnak = AnakAsuh::count();
        $totalPengasuh = Pengasuh::count();
        $totalKegiatan = Kegiatan::count();
        $totalDonatur  = Donasi::distinct('nama_donatur')->count();

        // ── Data Terbaru ──
        $donasiTerbaru  = Donasi::latest()->take(5)->get();
        $kegiatanTerbaru = Kegiatan::latest()->take(5)->get();

        $donasiTerbaru   = collect(); // collection kosong

        return view('admin.dashboard', compact(
            'totalAnak',
            'totalPengasuh',
            'totalKegiatan',
            'totalDonatur',
            'donasiTerbaru',
            'kegiatanTerbaru'
        ));
    }
}