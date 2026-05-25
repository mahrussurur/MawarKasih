<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->input('kategori', 'semua');
        $search = $request->input('search');

        $query = Galeri::query()->latest();

        if ($request->filled('kategori') && $kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        if ($search) {
            $query->where('judul', 'like', '%' . $search . '%');
        }

        $galeris = $query->paginate(10)->withQueryString();
        $totalGaleri = Galeri::count();
        $totalUmum = Galeri::where('kategori', 'umum')->count();
        $totalFasilitas = Galeri::where('kategori', 'fasilitas')->count();

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
            'kategori' => 'required|in:umum,fasilitas',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = $request->file('foto')->store('galeri', 'public');

        Galeri::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Foto galeri berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        return view('admin.galeri.show', compact('galeri'));
    }

    public function edit(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:umum,fasilitas',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $galeri = Galeri::findOrFail($id);
        $fotoPath = $galeri->foto;

        if ($request->hasFile('foto')) {
            if ($galeri->foto) {
                Storage::disk('public')->delete($galeri->foto);
            }

            $fotoPath = $request->file('foto')->store('galeri', 'public');
        }

        $galeri->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Data galeri berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->foto) {
            Storage::disk('public')->delete($galeri->foto);
        }

        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Data galeri berhasil dihapus!');
    }
}
