<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Kegiatan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKegiatan = Kegiatan::count();
        $totalGaleri = Galeri::count();
        $kegiatanTerbaru = Kegiatan::latest()->take(5)->get();

        return view('sekretaris.dashboard', compact('totalKegiatan', 'totalGaleri', 'kegiatanTerbaru'));
    }
}
