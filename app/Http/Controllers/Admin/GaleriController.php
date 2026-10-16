<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Services\ImageService;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

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

        return view('admin.galeri.index', compact('galeris', 'kategori', 'totalGaleri', 'totalUmum', 'totalFasilitas'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:Umum,Fasilitas',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'galeri');

        Galeri::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Foto galeri berhasil ditambahkan!');
    }

    public function show(Galeri $galeri)
    {
        return view('admin.galeri.show', compact('galeri'));
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:Umum,Fasilitas',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = $galeri->foto;

        if ($request->hasFile('foto')) {
            $this->imageService->deleteImage($galeri->foto);
            $fotoPath = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'galeri');
        }

        $galeri->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Data galeri berhasil diperbarui!');
    }

    public function destroy(Galeri $galeri)
    {
        $this->imageService->deleteImage($galeri->foto);
        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Data galeri berhasil dihapus!');
    }
}

