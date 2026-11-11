<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Services\ImageService;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Kegiatan::query()->latest();

        if ($search) {
            $query->where('nama_kegiatan', 'like', '%' . $search . '%');
        }

        $kegiatans = $query->paginate(10)->withQueryString();

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

        $fotoPath = $this->imageService->uploadAndGenerateWebp($request->file('foto_dokumentasi'), 'kegiatan');
        $deskripsiHtml = $this->sanitizeHtml($request->deskripsi);

        Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'deskripsi' => $deskripsiHtml,
            'foto_dokumentasi' => $fotoPath,
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required',
            'foto_dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = $kegiatan->foto_dokumentasi;

        if ($request->hasFile('foto_dokumentasi')) {
            $this->imageService->deleteImage($kegiatan->foto_dokumentasi);
            $fotoPath = $this->imageService->uploadAndGenerateWebp($request->file('foto_dokumentasi'), 'kegiatan');
        }

        $kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'deskripsi' => $this->sanitizeHtml($request->deskripsi),
            'foto_dokumentasi' => $fotoPath,
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil diperbarui!');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $this->imageService->deleteImage($kegiatan->foto_dokumentasi);
        $kegiatan->delete();

        return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil dihapus!');
    }

    private function sanitizeHtml($html)
    {
        if (empty($html)) {
            return null;
        }

        $allowedTags = '<p><br><strong><b><em><i><u><s><h1><h2><h3><h4><ul><ol><li><a><span><blockquote>';
        $html = strip_tags($html, $allowedTags);

        // Hapus BOM dan zero-width character
        $html = preg_replace('/[\x{FEFF}\x{200B}\x{200C}\x{200D}]/u', '', $html);
        $html = trim($html);

        // Hapus atribut on* dan javascript: URL menggunakan regex dasar
        $html = preg_replace('#(<[^>]+?[\x00-\x20"\'])(on|xmlns)[^>]*+>#i', '$1>', $html);
        $html = preg_replace('#href=[\'"]?javascript:[^\'"]*[\'"]?#i', 'href="#"', $html);

        // Hapus paragraf/tag kosong di awal dan akhir teks
        $emptyInner = '(?:[ \t\r\n]|<br\s*\/?>|&nbsp;|&#160;|\x{00a0}|<span>(?:[ \t\r\n]|<br\s*\/?>|&nbsp;|&#160;|\x{00a0})*<\/span>)*';
        do {
            $before = $html;
            $html = preg_replace('/^(\s*<(p|div|h[1-6]|blockquote)[^>]*>' . $emptyInner . '<\/\2>\s*|<br\s*\/?>|\s)+/iu', '', $html);
        } while ($html !== $before && !empty($html));

        do {
            $before = $html;
            $html = preg_replace('/(\s*<(p|div|h[1-6]|blockquote)[^>]*>' . $emptyInner . '<\/\2>\s*|<br\s*\/?>|\s)+$/iu', '', $html);
        } while ($html !== $before && !empty($html));

        // Hilangkan whitespace/newline antar tag
        $html = preg_replace('/>\s+</u', '><', $html);

        return trim($html);
    }
}