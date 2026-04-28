<?php

namespace App\Http\Controllers;

use App\Models\AnakAsuh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class AnakAsuhController extends Controller
{
    public function index()
    {
        $data = AnakAsuh::latest()->paginate(10);
        return view('anak_asuh.index', compact('data'));
    }

    public function create()
    {
        return view('anak_asuh.create');
    }

    public function store(Request $request)
{
    // 1. Validasi semua field yang ada di model agar tidak ada data kosong yang lolos ke database
    $validated = $request->validate([
        'nama'               => 'required|string|max:255',
        'tempat_lahir'       => 'required|string|max:255',
        'tanggal_lahir'      => 'required|date',
        'jenis_kelamin'      => 'required|in:L,P',
        'status_social_anak' => 'nullable|string',
        'nama_ayah'          => 'nullable|string|max:255',
        'nama_ibu'           => 'nullable|string|max:255',
        'foto'               => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 2. Proses upload foto
    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('anak_asuh', 'public');
    }

    // 3. Simpan data menggunakan variabel $validated yang sudah lengkap
    \App\Models\AnakAsuh::create($validated);

    // 4. Redirect ke index agar user bisa langsung melihat hasil datanya di tabel
    return redirect()->route('anak-asuh.index')->with('success', 'Data berhasil ditambahkan');
}

    public function destroy($id)
    {
        $anak = AnakAsuh::findOrFail($id);
        if($anak->foto) Storage::disk('public')->delete($anak->foto);
        $anak->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function cetak()
    {
        // Ambil semua data anak asuh
        $data = AnakAsuh::all();
        
        // Load view khusus untuk PDF
        $pdf = Pdf::loadView('anak_asuh.cetak', compact('data'));
        
        // Download atau tampilkan PDF di browser
        // Untuk menampilkan di browser pakai ->stream(), untuk langsung download pakai ->download()
        return $pdf->stream('Laporan_Data_Anak_Asuh_Mawar_Kasih.pdf');
    }
}