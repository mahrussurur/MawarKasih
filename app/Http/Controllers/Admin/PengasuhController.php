<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengasuh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ImageService;

class PengasuhController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function index(Request $request)
    {
        $query = Pengasuh::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10)->withQueryString();
        return view('admin.pengasuh.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pengasuh.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string|max:255',
            'jabatan'       => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'required|digits_between:10,15',
            'foto'          => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'pengasuh');
        }

        Pengasuh::create($validated);

        return redirect()->route('pengasuh.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(Pengasuh $pengasuh)
    {
        return view('admin.pengasuh.show', compact('pengasuh'));
    }

    public function edit(Pengasuh $pengasuh)
    {
        return view('admin.pengasuh.edit', compact('pengasuh'));
    }

    public function update(Request $request, Pengasuh $pengasuh)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
            'jabatan'       => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'required|numeric',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $this->imageService->deleteImage($pengasuh->foto);
            $validated['foto'] = $this->imageService->uploadAndGenerateWebp($request->file('foto'), 'pengasuh');
        }

        $pengasuh->update($validated);

        return redirect()->route('pengasuh.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $pengasuh = Pengasuh::findOrFail($id);
        $this->imageService->deleteImage($pengasuh->foto);
        $pengasuh->delete();
        
        return redirect()->route('pengasuh.index')->with('success', 'Data berhasil dihapus');
    }

    public function cetak()
    {
        $data = Pengasuh::all();
        $pdf = Pdf::loadView('admin.pengasuh.cetak', compact('data'));
        return $pdf->stream('Laporan_Data_Pengasuh_Mawar_Kasih.pdf');
    }
}
