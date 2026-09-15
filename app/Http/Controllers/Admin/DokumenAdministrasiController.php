<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenAdministrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenAdministrasiController extends Controller
{
    public function index(Request $request)
    {
        $dokumen = DokumenAdministrasi::query()
            ->latest()
            ->when($request->search, function ($query, $search) {
                $query->where('judul', 'like', "%{$search}%")
                      ->orWhere('nomor_dokumen', 'like', "%{$search}%");
            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.dokumen.index', compact('dokumen'));
    }

    public function create()
    {
        return view('admin.dokumen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'nomor_dokumen'   => 'nullable|string|max:255',
            'jenis_dokumen'   => 'nullable|string|max:255',
            'keterangan'      => 'nullable|string',
            'tanggal_dokumen' => 'nullable|date',
            'file_dokumen'    => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        $path = $request->file('file_dokumen')->store('dokumen_administrasi', 'public');

        DokumenAdministrasi::create([
            'judul'           => $request->judul,
            'nomor_dokumen'   => $request->nomor_dokumen,
            'jenis_dokumen'   => $request->jenis_dokumen,
            'keterangan'      => $request->keterangan,
            'tanggal_dokumen' => $request->tanggal_dokumen,
            'file_path'       => $path,
            'diupload_oleh'   => Auth::id(),
        ]);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function show(DokumenAdministrasi $dokuman)
    {
        return view('admin.dokumen.show', ['dokumen' => $dokuman]);
    }

    public function edit(DokumenAdministrasi $dokuman)
    {
        return view('admin.dokumen.edit', ['dokumen' => $dokuman]);
    }

    public function update(Request $request, DokumenAdministrasi $dokuman)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'nomor_dokumen'   => 'nullable|string|max:255',
            'jenis_dokumen'   => 'nullable|string|max:255',
            'keterangan'      => 'nullable|string',
            'tanggal_dokumen' => 'nullable|date',
            'file_dokumen'    => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only(['judul', 'nomor_dokumen', 'jenis_dokumen', 'keterangan', 'tanggal_dokumen']);

        if ($request->hasFile('file_dokumen')) {
            if ($dokuman->file_path && Storage::disk('public')->exists($dokuman->file_path)) {
                Storage::disk('public')->delete($dokuman->file_path);
            }
            $data['file_path'] = $request->file('file_dokumen')->store('dokumen_administrasi', 'public');
        }

        $dokuman->update($data);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(DokumenAdministrasi $dokuman)
    {
        if ($dokuman->file_path && Storage::disk('public')->exists($dokuman->file_path)) {
            Storage::disk('public')->delete($dokuman->file_path);
        }
        $dokuman->delete();
        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
