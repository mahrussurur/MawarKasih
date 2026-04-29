<?php

namespace App\Http\Controllers;

use App\Models\Pengasuh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PengasuhController extends Controller
{
    public function index()
    {
        $data = Pengasuh::latest()->paginate(10);
        return view('pengasuh.index', compact('data'));
    }

    public function create()
    {
        return view('pengasuh.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'jabatan'       => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'required|string|max:20',
            'foto'          => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pengasuh', 'public');
        }

        Pengasuh::create($validated);

        return redirect()->route('pengasuh.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show(Pengasuh $pengasuh)
    {
        return view('pengasuh.show', compact('pengasuh'));
    }

    public function edit(Pengasuh $pengasuh)
    {
        return view('pengasuh.edit', compact('pengasuh'));
    }

    public function update(Request $request, Pengasuh $pengasuh)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'jabatan'       => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'required|string|max:20',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($pengasuh->foto) {
                Storage::disk('public')->delete($pengasuh->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pengasuh', 'public');
        }

        $pengasuh->update($validated);

        return redirect()->route('pengasuh.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $pengasuh = Pengasuh::findOrFail($id);
        if($pengasuh->foto) Storage::disk('public')->delete($pengasuh->foto);
        $pengasuh->delete();
        
        return redirect()->route('pengasuh.index')->with('success', 'Data berhasil dihapus');
    }

    public function cetak()
    {
        $data = Pengasuh::all();
        $pdf = Pdf::loadView('pengasuh.cetak', compact('data'));
        return $pdf->stream('Laporan_Data_Pengasuh_Mawar_Kasih.pdf');
    }
}
