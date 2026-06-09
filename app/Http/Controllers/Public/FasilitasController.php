<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galeri;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Galeri::where('kategori', 'fasilitas')->latest()->get();

        return view('public.fasilitas', compact('fasilitas'));
    }
}
