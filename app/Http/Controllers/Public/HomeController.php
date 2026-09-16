<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AnakAsuh;
use App\Models\User;
use App\Models\Kegiatan;
use App\Models\Galeri;
use App\Models\Donasi;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'totalAnakAsuh'  => AnakAsuh::count(),
            'totalPengasuh'  => User::where('role', 'pengasuh')->count(),
            'totalKegiatan'  => Kegiatan::count(),
            'totalDonatur'   => User::where('role', 'donatur')->count(),
            'totalDonasi'    => Donasi::count(),
        ];

        $kegiatans = Kegiatan::latest('tanggal_pelaksanaan')
            ->get();

        $fasilitas = Galeri::where('kategori', 'Fasilitas')->latest()->get();

        return view('public.home', compact('stats', 'kegiatans', 'fasilitas'));
    }
}
