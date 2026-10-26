<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\ArsipDokumen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArsipDokumenController extends Controller
{
    /**
     * Menampilkan daftar arsip dokumen administrasi (read-only untuk Ketua).
     */
    public function index(Request $request): View
    {
        $query = ArsipDokumen::with('uploader.profilPegawai')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('nomor_dokumen', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('file_name_asli', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $arsips = $query->paginate(10)->withQueryString();
        $totalArsip = ArsipDokumen::count();
        $kategoriList = ['Legalitas', 'Surat Masuk', 'Surat Keluar', 'Notula Rapat', 'Lainnya'];

        return view('ketua.arsip-dokumen.index', compact('arsips', 'totalArsip', 'kategoriList'));
    }

    /**
     * Menampilkan rincian metadata dokumen (read-only untuk Ketua).
     */
    public function show(ArsipDokumen $arsip): View
    {
        $arsip->load('uploader.profilPegawai');
        return view('ketua.arsip-dokumen.show', compact('arsip'));
    }

    /**
     * Mengunduh berkas fisik dokumen administrasi.
     */
    public function download(ArsipDokumen $arsip): StreamedResponse|RedirectResponse
    {
        if (! Storage::disk('local')->exists($arsip->file_path)) {
            return redirect()->back()->with('error', 'Berkas fisik dokumen tidak ditemukan di penyimpanan server.');
        }

        return Storage::disk('local')->download($arsip->file_path, $arsip->file_name_asli);
    }
}
