<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AnakAsuh;
use App\Models\Donasi;
use App\Models\Galeri;
use App\Models\Kegiatan;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'totalAnakAsuh'  => AnakAsuh::count(),
            'totalPengurus'  => User::whereIn('role', ['admin', 'bendahara', 'ketua'])->count(),
            'totalDonatur'   => User::where('role', 'donatur')->count(),
            'totalDonasi'    => Donasi::count(),
        ];

        $kegiatans = Kegiatan::latest('tanggal_pelaksanaan')->get();

        $fasilitas = Galeri::where('kategori', 'Fasilitas')->latest()->get();

        return view('public.home', compact('stats', 'kegiatans', 'fasilitas'));
    }
}
