<?php

// app/Http/Controllers/Public/GalleryController.php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galeri; // Sesuaikan dengan model Anda
use Illuminate\Http\Request;

class GaleriPublicController extends Controller
{
    public function index()
    {
        $galleries = Galeri::where('kategori', 'umum')->latest()->paginate(12); // Sesuaikan jumlah per halaman
        return view('public.galeri.index', compact('galleries'));
    }

    public function show($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('public.galeri.show', compact('galeri'));
    }
}
