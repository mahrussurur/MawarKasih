<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $kegiatans = $query->paginate(10);
        return view('sekretaris.kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        return view('sekretaris.kegiatan.create');
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

        Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'deskripsi' => $request->deskripsi,
            'foto_dokumentasi' => $fotoPath,
        ]);

        return redirect()->route('sekretaris.kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('sekretaris.kegiatan.show', compact('kegiatan'));
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('sekretaris.kegiatan.edit', compact('kegiatan'));
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

        return redirect()->route('sekretaris.kegiatan.index')->with('success', 'Data kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $this->imageService->deleteImage($kegiatan->foto_dokumentasi);
        $kegiatan->delete();

        return redirect()->route('sekretaris.kegiatan.index')->with('success', 'Data kegiatan berhasil dihapus!');
    }

    public function cetak(Request $request)
    {
        $query = Kegiatan::orderBy('tanggal_pelaksanaan', 'desc');

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pelaksanaan', $request->tahun);
        }

        $kegiatans    = $query->get();
        $tahun        = $request->tahun ?? 'Semua Tahun';

        $pdf = Pdf::loadView('sekretaris.kegiatan.cetak', compact('kegiatans', 'tahun'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Kegiatan_Mawar_Kasih.pdf');
    }
}
