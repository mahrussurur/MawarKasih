<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AnakAsuh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nama_sekolah_terakhir', 'like', "%{$search}%")
                  ->orWhere('pendidikan_terakhir', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10)->withQueryString();

        return view('admin.alumni.index', compact('data'));
    }

    public function create($anak_asuh_id)
    {
        $anakAsuh = AnakAsuh::findOrFail($anak_asuh_id);
        
        if ($anakAsuh->alumni()->exists()) {
            return redirect()->route('anak-asuh.index')->with('error', 'Anak asuh ini sudah menjadi alumni.');
        }

        return view('admin.alumni.create', compact('anakAsuh'));
    }

    public function store(Request $request, $anak_asuh_id)
    {
        $anakAsuh = AnakAsuh::findOrFail($anak_asuh_id);
        
        if ($anakAsuh->alumni()->exists()) {
            return redirect()->route('anak-asuh.index')->with('error', 'Anak asuh ini sudah menjadi alumni.');
        }

        $validated = $request->validate([
            'tanggal_keluar' => 'required|date',
            'pendidikan_terakhir' => 'nullable|string',
            'nama_sekolah_terakhir' => 'nullable|string',
            'pekerjaan' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($anakAsuh, $validated) {
            Alumni::create([
                'anak_asuh_id' => $anakAsuh->id,
                'foto' => $anakAsuh->foto,
                'nama' => $anakAsuh->nama,
                'nama_panggilan' => $anakAsuh->nama_panggilan,
                'tempat_lahir' => $anakAsuh->tempat_lahir,
                'tanggal_lahir' => $anakAsuh->tanggal_lahir,
                'jenis_kelamin' => $anakAsuh->jenis_kelamin,
                'status_social_anak' => $anakAsuh->status_social_anak,
                'nama_ayah' => $anakAsuh->nama_ayah,
                'nama_ibu' => $anakAsuh->nama_ibu,
                'tinggal_di_lksa_sejak' => $anakAsuh->tinggal_di_lksa_sejak,
                'sekolah' => $anakAsuh->sekolah,
                'kelas' => $anakAsuh->kelas,
                
                'tanggal_keluar' => $validated['tanggal_keluar'],
                'pendidikan_terakhir' => $validated['pendidikan_terakhir'],
                'nama_sekolah_terakhir' => $validated['nama_sekolah_terakhir'],
                'pekerjaan' => $validated['pekerjaan'],
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
                'catatan' => $validated['catatan'],
            ]);

            $anakAsuh->delete(); // Soft Delete
        });

        return redirect()->route('alumni.index')->with('success', 'Anak asuh berhasil dijadikan alumni');
    }

    public function show(Alumni $alumni)
    {
        return view('admin.alumni.show', compact('alumni'));
    }

    public function edit(Alumni $alumni)
    {
        return view('admin.alumni.edit', compact('alumni'));
    }

    public function update(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'tanggal_keluar' => 'required|date',
            'pendidikan_terakhir' => 'nullable|string',
            'nama_sekolah_terakhir' => 'nullable|string',
            'pekerjaan' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $alumni->update($validated);

        return redirect()->route('alumni.index')->with('success', 'Data alumni berhasil diupdate');
    }
}
