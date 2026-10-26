<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreArsipDokumenRequest;
use App\Http\Requests\Admin\UpdateArsipDokumenRequest;
use App\Models\ArsipDokumen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArsipDokumenController extends Controller
{
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

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        $arsips = $query->paginate(10)->withQueryString();
        $totalArsip = ArsipDokumen::count();
        $kategoriList = ['Legalitas', 'Surat Masuk', 'Surat Keluar', 'Notula Rapat', 'Lainnya'];

        return view('admin.arsip-dokumen.index', compact('arsips', 'totalArsip', 'kategoriList'));
    }

    public function create(): View
    {
        $kategoriList = ['Legalitas', 'Surat Masuk', 'Surat Keluar', 'Notula Rapat', 'Lainnya'];
        return view('admin.arsip-dokumen.create', compact('kategoriList'));
    }

    public function store(StoreArsipDokumenRequest $request): RedirectResponse
    {
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType() ?: $file->getClientMimeType();

        // Simpan file ke private local storage
        $storedPath = $file->store('arsip-dokumen', 'local');

        try {
            DB::transaction(function () use ($request, $originalName, $storedPath, $fileSize, $mimeType) {
                ArsipDokumen::create([
                    'judul' => $request->judul,
                    'nomor_dokumen' => $request->nomor_dokumen,
                    'kategori' => $request->kategori,
                    'tanggal_dokumen' => $request->tanggal_dokumen,
                    'deskripsi' => $request->deskripsi,
                    'file_name_asli' => $originalName,
                    'file_path' => $storedPath,
                    'file_size' => $fileSize,
                    'mime_type' => $mimeType,
                    'uploaded_by' => Auth::id(),
                ]);
            });
        } catch (\Throwable $e) {
            if ($storedPath && Storage::disk('local')->exists($storedPath)) {
                Storage::disk('local')->delete($storedPath);
            }
            throw $e;
        }

        return redirect()->route('admin.arsip-dokumen.index')
            ->with('success', 'Dokumen administrasi berhasil diarsipkan.');
    }

    public function show(ArsipDokumen $arsip): View
    {
        $arsip->load('uploader.profilPegawai');
        return view('admin.arsip-dokumen.show', compact('arsip'));
    }

    public function edit(ArsipDokumen $arsip): View
    {
        $kategoriList = ['Legalitas', 'Surat Masuk', 'Surat Keluar', 'Notula Rapat', 'Lainnya'];
        return view('admin.arsip-dokumen.edit', compact('arsip', 'kategoriList'));
    }

    public function update(UpdateArsipDokumenRequest $request, ArsipDokumen $arsip): RedirectResponse
    {
        $oldFilePath = $arsip->file_path;
        $storedPath = null;

        try {
            DB::transaction(function () use ($request, $arsip, &$storedPath, $oldFilePath) {
                $data = [
                    'judul' => $request->judul,
                    'nomor_dokumen' => $request->nomor_dokumen,
                    'kategori' => $request->kategori,
                    'tanggal_dokumen' => $request->tanggal_dokumen,
                    'deskripsi' => $request->deskripsi,
                ];

                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $storedPath = $file->store('arsip-dokumen', 'local');

                    $data['file_name_asli'] = $file->getClientOriginalName();
                    $data['file_path'] = $storedPath;
                    $data['file_size'] = $file->getSize();
                    $data['mime_type'] = $file->getMimeType() ?: $file->getClientMimeType();
                }

                $arsip->update($data);
            });

            // Hapus file lama jika ada pergantian file baru
            if ($storedPath && $oldFilePath && Storage::disk('local')->exists($oldFilePath)) {
                Storage::disk('local')->delete($oldFilePath);
            }
        } catch (\Throwable $e) {
            if ($storedPath && Storage::disk('local')->exists($storedPath)) {
                Storage::disk('local')->delete($storedPath);
            }
            throw $e;
        }

        return redirect()->route('admin.arsip-dokumen.index')
            ->with('success', 'Data arsip dokumen berhasil diperbarui.');
    }

    public function download(ArsipDokumen $arsip): StreamedResponse|RedirectResponse
    {
        if (! Storage::disk('local')->exists($arsip->file_path)) {
            return redirect()->back()->with('error', 'Berkas fisik dokumen tidak ditemukan di penyimpanan server.');
        }

        return Storage::disk('local')->download($arsip->file_path, $arsip->file_name_asli);
    }

    public function destroy(ArsipDokumen $arsip): RedirectResponse
    {
        $filePath = $arsip->file_path;

        DB::transaction(function () use ($arsip) {
            $arsip->delete();
        });

        if ($filePath && Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
        }

        return redirect()->route('admin.arsip-dokumen.index')
            ->with('success', 'Arsip dokumen berhasil dihapus.');
    }
}
