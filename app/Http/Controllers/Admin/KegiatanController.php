<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    // Fungsi __construct dan middleware-nya sudah DIHAPUS

    public function index(Request $request)
    {
        // 1. Tangkap apa yang diketik/dipilih oleh admin
        $search = $request->input('search');

        // 2. Siapkan pondasi query database
        $query = Kegiatan::query()->latest();

        // 3. Jika admin mengetik di kotak pencarian, saring berdasarkan judul
        if ($search) {
            $query->where('nama_kegiatan', 'like', '%' . $search . '%');
        }

        // 5. Eksekusi query-nya dan urutkan dari yang terbaru
        $kegiatans = $query->latest()->paginate(10);

        // 6. Kirim datanya ke halaman View
        return view('admin.kegiatan.index', compact('kegiatans'));
    }
    public function create()
    {
        // Menampilkan form tambah data
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi data yang diketik oleh admin
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required',
            'foto_dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Siapkan tempat untuk menyimpan nama file foto
        $fotoPath = null;

        // 3. Cek apakah admin mengunggah foto
        if ($request->hasFile('foto_dokumentasi')) {
            // Simpan foto ke dalam folder 'storage/app/public/kegiatan'
            $fotoPath = $request->file('foto_dokumentasi')->store('kegiatan', 'public');
        }

        // 4. Masukkan semua data ke database
        Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'deskripsi' => $request->deskripsi,
            'foto_dokumentasi' => $fotoPath,
        ]);

        // 5. Kembalikan admin ke halaman tabel dengan pesan sukses
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show($id)
    {
        // 1. Cari data kegiatan di database berdasarkan ID-nya
        // (Gunakan findOrFail agar jika ID tidak ada, langsung muncul error 404 yang rapi)
        $kegiatan = Kegiatan::findOrFail($id);

        // 2. Tampilkan halaman detail dan kirim datanya
        return view('admin.kegiatan.show', compact('kegiatan'));
    }

    // Jangan lupa tambahkan ini di bagian atas file (di bawah namespace) jika belum ada:


    public function edit($id)
    {
        // 1. Cari data kegiatan yang mau diedit
        $kegiatan = Kegiatan::findOrFail($id);

        // 2. Tampilkan halaman form edit dan bawa datanya
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi data yang diubah
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required',
            'foto_dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        
        // 2. Siapkan variabel untuk nama file foto (default pakai foto lama)
        $fotoPath = $kegiatan->foto_dokumentasi;

        // 3. Cek apakah admin mengunggah foto baru
        if ($request->hasFile('foto_dokumentasi')) {
            // Hapus foto lama dari storage jika ada
            if ($kegiatan->foto_dokumentasi) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($kegiatan->foto_dokumentasi);
            }
            // Simpan foto baru
            $fotoPath = $request->file('foto_dokumentasi')->store('kegiatan', 'public');
        }

        // 4. Update data ke database
        $kegiatan->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'deskripsi' => $request->deskripsi,
            'foto_dokumentasi' => $fotoPath,
        ]);

        // 5. Kembalikan ke halaman tabel dengan pesan sukses
        return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // 1. Cari data kegiatan yang mau dihapus berdasarkan ID
        $kegiatan = Kegiatan::findOrFail($id);

        // 2. Hapus juga file fotonya dari folder storage (agar server tidak penuh)
        if ($kegiatan->foto_dokumentasi) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($kegiatan->foto_dokumentasi);
        }

        // 3. Hapus data dari database
        $kegiatan->delete();

        // 4. Kembalikan ke halaman tabel dengan pesan sukses
        return redirect()->route('kegiatan.index')->with('success', 'Data kegiatan berhasil dihapus!');
    }
}