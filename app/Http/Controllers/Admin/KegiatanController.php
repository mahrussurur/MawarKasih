<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class KegiatanController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Kegiatan::query()->latest();

        if ($search) {
            $query->where('nama_kegiatan', 'like', '%' . $search . '%');
        }

        $kegiatans = $query->latest()->paginate(10);

        return view('admin.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required',
            'foto_dokumentasi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto_dokumentasi')) {
            $fotoPath = $this->imageService->uploadAndGenerateWebp($request->file('foto_dokumentasi'), 'kegiatan');
        }

        $deskripsiHtml = $this->sanitizeHtml($request->deskripsi);

        Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'deskripsi' => $deskripsiHtml,
            'foto_dokumentasi' => $fotoPath,
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required',
            'foto_dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        
        $fotoPath = $kegiatan->foto_dokumentasi;

        if ($request->hasFile('foto_dokumentasi')) {
            $this->imageService->deleteImage($kegiatan->foto_dokumentasi);
            $fotoPath = $this->imageService->uploadAndGenerateWebp($request->file('foto_dokumentasi'), 'kegiatan');
        }

        $kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'deskripsi' => $request->deskripsi,
            'foto_dokumentasi' => $fotoPath,
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $this->imageService->deleteImage($kegiatan->foto_dokumentasi);

        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil dihapus!');
    }

    private function sanitizeHtml($html)
    {
        if (empty($html)) return null;
        
        $allowedTags = '<p><br><strong><em><u><h1><h2><ul><ol><li><a>';
        $html = strip_tags($html, $allowedTags);

        // Hapus atribut on* dan javascript: URL menggunakan regex dasar
        $html = preg_replace('#(<[^>]+?[\x00-\x20"\'])(on|xmlns)[^>]*+>#i', '$1>', $html);
        $html = preg_replace('#href=[\'"]?javascript:[^\'"]*[\'"]?#i', 'href="#"', $html);

        return $html;
    }
}