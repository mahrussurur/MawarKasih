<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->input('kategori', 'Semua');
        $search = $request->input('search');

        $query = Galeri::query()->latest();

        if ($request->filled('kategori') && $kategori !== 'Semua') {
            $query->where('kategori', $kategori);
        }

        if ($search) {
            $query->where('judul', 'like', '%' . $search . '%');
        }

        $galeris = $query->paginate(10)->withQueryString();
        $totalGaleri = Galeri::count();
        $totalUmum = Galeri::where('kategori', 'Umum')->count();
        $totalFasilitas = Galeri::where('kategori', 'Fasilitas')->count();

        return view('sekretaris.galeri.index', compact('galeris', 'kategori', 'totalGaleri', 'totalUmum', 'totalFasilitas'));
    }

    public function show(Galeri $galeri)
    {
        return view('sekretaris.galeri.show', compact('galeri'));
    }
}

