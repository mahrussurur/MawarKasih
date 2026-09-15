<?php

namespace App\Http\Controllers\Pengasuh;

use App\Http\Controllers\Controller;
use App\Models\AnakAsuh;
use App\Models\CatatanPerkembangan;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanPerkembanganController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request)
    {
        $query = CatatanPerkembangan::with('anakAsuh', 'pengasuh')->latest('tanggal');

        if ($request->filled('anak_asuh_id')) {
            $query->where('anak_asuh_id', $request->anak_asuh_id);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $catatans = $query->paginate(10)->withQueryString();
        $anakList = AnakAsuh::orderBy('nama')->get(['id', 'nama']);
        $kategoriList = ['Pendidikan', 'Kesehatan', 'Sosial', 'Lainnya'];

        return view('pengasuh.catatan_perkembangan.index', compact('catatans', 'anakList', 'kategoriList'));
    }

    public function create()
    {
        $anakList = AnakAsuh::orderBy('nama')->get(['id', 'nama']);
        $kategoriList = ['Pendidikan', 'Kesehatan', 'Sosial', 'Lainnya'];
        return view('pengasuh.catatan_perkembangan.create', compact('anakList', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anak_asuh_id' => 'required|exists:anak_asuh,id',
            'tanggal'      => 'required|date',
            'kategori'     => 'required|in:Pendidikan,Kesehatan,Sosial,Lainnya',
            'catatan'      => 'required|string',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['pengasuh_id'] = Auth::id();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'catatan_perkembangan');
        }

        CatatanPerkembangan::create($validated);

        return redirect()->route('pengasuh.catatan-perkembangan.index')
                         ->with('success', 'Catatan perkembangan berhasil ditambahkan!');
    }

    public function show(CatatanPerkembangan $catatanPerkembangan)
    {
        $catatanPerkembangan->load('anakAsuh', 'pengasuh');
        return view('pengasuh.catatan_perkembangan.show', compact('catatanPerkembangan'));
    }

    public function edit(CatatanPerkembangan $catatanPerkembangan)
    {
        $anakList = AnakAsuh::orderBy('nama')->get(['id', 'nama']);
        $kategoriList = ['Pendidikan', 'Kesehatan', 'Sosial', 'Lainnya'];
        return view('pengasuh.catatan_perkembangan.edit', compact('catatanPerkembangan', 'anakList', 'kategoriList'));
    }

    public function update(Request $request, CatatanPerkembangan $catatanPerkembangan)
    {
        $validated = $request->validate([
            'anak_asuh_id' => 'required|exists:anak_asuh,id',
            'tanggal'      => 'required|date',
            'kategori'     => 'required|in:Pendidikan,Kesehatan,Sosial,Lainnya',
            'catatan'      => 'required|string',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $this->imageService->deleteImage($catatanPerkembangan->foto);
            $validated['foto'] = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'catatan_perkembangan');
        }

        $catatanPerkembangan->update($validated);

        return redirect()->route('pengasuh.catatan-perkembangan.index')
                         ->with('success', 'Catatan perkembangan berhasil diperbarui!');
    }

    public function destroy(CatatanPerkembangan $catatanPerkembangan)
    {
        $this->imageService->deleteImage($catatanPerkembangan->foto);
        $catatanPerkembangan->delete();

        return redirect()->route('pengasuh.catatan-perkembangan.index')
                         ->with('success', 'Catatan perkembangan berhasil dihapus!');
    }
}
