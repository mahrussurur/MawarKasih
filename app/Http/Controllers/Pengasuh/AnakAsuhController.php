<?php

namespace App\Http\Controllers\Pengasuh;

use App\Http\Controllers\Controller;
use App\Models\AnakAsuh;
use App\Services\ImageService;
use Illuminate\Http\Request;

class AnakAsuhController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

    public function index(Request $request)
    {
        $query = AnakAsuh::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nama_panggilan', 'like', "%{$search}%")
                  ->orWhere('nama_ayah', 'like', "%{$search}%")
                  ->orWhere('nama_ibu', 'like', "%{$search}%")
                  ->orWhere('sekolah', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10)->withQueryString();
        $totalData = AnakAsuh::count();

        return view('pengasuh.anak_asuh.index', compact('data', 'totalData'));
    }

    public function create()
    {
        return view('pengasuh.anak_asuh.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto'                  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama'                  => 'required|string|max:255',
            'nama_panggilan'        => 'required|string|max:255',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|date',
            'jenis_kelamin'         => 'required|in:L,P',
            'status_social_anak'    => 'required|string|max:255',
            'nama_ayah'             => 'nullable|string|max:255',
            'nama_ibu'              => 'nullable|string|max:255',
            'tinggal_di_lksa_sejak' => 'required|string|max:255',
            'sekolah'               => 'required|string|max:255',
            'kelas'                 => 'required|string|max:255',
        ]);

        if (in_array($validated['status_social_anak'], ['Yatim', 'Yatim Piatu'])) {
            $validated['nama_ayah'] = null;
        }
        if (in_array($validated['status_social_anak'], ['Piatu', 'Yatim Piatu'])) {
            $validated['nama_ibu'] = null;
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'anak_asuh');
        }

        AnakAsuh::create($validated);

        return redirect()->route('pengasuh.anak-asuh.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(AnakAsuh $anakAsuh)
    {
        return view('pengasuh.anak_asuh.show', compact('anakAsuh'));
    }

    public function edit(AnakAsuh $anakAsuh)
    {
        return view('pengasuh.anak_asuh.edit', compact('anakAsuh'));
    }

    public function update(Request $request, AnakAsuh $anakAsuh)
    {
        $validated = $request->validate([
            'nama'                  => 'required|string|max:255',
            'nama_panggilan'        => 'required|string|max:255',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|date',
            'jenis_kelamin'         => 'required|in:L,P',
            'status_social_anak'    => 'nullable|string|max:255',
            'nama_ayah'             => 'nullable|string|max:255',
            'nama_ibu'              => 'nullable|string|max:255',
            'tinggal_di_lksa_sejak' => 'required|string|max:255',
            'sekolah'               => 'required|string|max:255',
            'kelas'                 => 'required|string|max:255',
            'foto'                  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $this->imageService->deleteImage($anakAsuh->foto);
            $validated['foto'] = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'anak_asuh');
        }

        $anakAsuh->update($validated);

        return redirect()->route('pengasuh.anak-asuh.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(AnakAsuh $anakAsuh)
    {
        $this->imageService->deleteImage($anakAsuh->foto);
        $anakAsuh->delete();
        return redirect()->route('pengasuh.anak-asuh.index')->with('success', 'Data berhasil dihapus');
    }
}
