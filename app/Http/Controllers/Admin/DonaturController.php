<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DonaturController extends Controller
{
    public function index()
    {
        $data = Donatur::latest()->paginate(10);
        return view('admin.donatur.index', compact('data'));
    }

    public function create()
    {
        return view('admin.donatur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email|unique:donaturs,email',
            'no_hp'   => 'required|string|max:20',
            'alamat'  => 'required|string',
            'status'  => 'required|in:aktif,tidak_aktif',
        ]);

        Donatur::create($validated);

        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil ditambahkan');
    }

    public function show(Donatur $donatur)
    {
        return view('admin.donatur.show', compact('donatur'));
    }

    public function edit(Donatur $donatur)
    {
        return view('admin.donatur.edit', compact('donatur'));
    }

    public function update(Request $request, Donatur $donatur)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email|unique:donaturs,email,' . $donatur->id,
            'no_hp'   => 'required|string|max:20',
            'alamat'  => 'required|string',
            'status'  => 'required|in:aktif,tidak_aktif',
        ]);

        $donatur->update($validated);

        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil diupdate');
    }

    public function destroy($id)
    {
        $donatur = Donatur::findOrFail($id);
        $donatur->delete();
        
        return redirect()->route('donatur.index')->with('success', 'Data donatur berhasil dihapus');
    }

    public function cetak()
    {
        $data = Donatur::all();
        $pdf = Pdf::loadView('admin.donatur.cetak', compact('data'));
        return $pdf->stream('Laporan_Data_Donatur_Mawar_Kasih.pdf');
    }
}
