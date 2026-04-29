<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\AnakAsuh;
use App\Models\Pengasuh;
// use App\Models\Donasi;
// use App\Models\Kegiatan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnak = AnakAsuh::count();
        $totalPengasuh = Pengasuh::count();
        // $totalKegiatan = Kegiatan::count();
        // $totalDonatur  = Donasi::distinct('nama_donatur')->count();

        // ── Data Terbaru ──
        // $donasiTerbaru  = Donasi::latest()->take(5)->get();
        // $kegiatanTerbaru = Kegiatan::latest('tanggal')->take(5)->get();

        $totalKegiatan   = 0;
        $totalDonatur    = 0;
        $donasiTerbaru   = collect(); // collection kosong
        $kegiatanTerbaru = collect(); // collection kosong

        return view('dashboard', compact(
            'totalAnak',
            'totalPengasuh',
            'totalKegiatan',
            'totalDonatur',
            'donasiTerbaru',
            'kegiatanTerbaru'
        ));
    }
}