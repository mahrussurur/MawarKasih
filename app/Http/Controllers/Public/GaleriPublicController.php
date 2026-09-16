<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriPublicController extends Controller
{
    public function index()
    {
        $galleries = Galeri::where('kategori', 'Umum')->latest()->paginate(12);
        return view('public.tentang.galeri', compact('galleries'));
    }

    public function show($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('public.galeri.show', compact('galeri'));
    }
}
