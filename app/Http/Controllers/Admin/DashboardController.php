<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\AnakAsuh;
use App\Models\Pengasuh;
use App\Models\Donasi;
use App\Models\Kegiatan;
use App\Models\Donatur;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnak = AnakAsuh::count();
        $totalPengasuh = Pengasuh::count();
        $totalKegiatan = Kegiatan::count();
        $totalDonatur = Donatur::count();

        $donasiTerbaru  = Donasi::latest()->take(5)->get();
        $kegiatanTerbaru = Kegiatan::latest()->take(5)->get();

        $donasiTerbaru   = collect();

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