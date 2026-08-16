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

        $donasiTerbaru  = Donasi::where('status', 'pending')->latest()->take(5)->get();
        $totalDonasiPending = Donasi::where('status', 'pending')->count();
        $kegiatanTerbaru = Kegiatan::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalAnak',
            'totalPengasuh',
            'totalKegiatan',
            'totalDonatur',
            'donasiTerbaru',
            'totalDonasiPending',
            'kegiatanTerbaru'
        ));
    }
}