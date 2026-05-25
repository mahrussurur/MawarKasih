<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; // pastikan package dompdf terinstall

class DonasiController extends Controller
{
    /**
     * Halaman daftar donasi — dengan filter status & search.
     */
    public function index(Request $request)
    {
        $query = Donasi::query()->latest();

        // Filter by status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Search by nama donatur atau kode donasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_donatur', 'like', "%{$search}%")
                  ->orWhere('kode_donasi', 'like', "%{$search}%");
            });
        }

        $donasi = $query->paginate(10)->withQueryString();

        // Hitung total per status untuk summary cards
        $totalPending  = Donasi::where('status', 'pending')->count();
        $totalValid    = Donasi::where('status', 'valid')->count();
        $totalDitolak  = Donasi::where('status', 'ditolak')->count();
        $totalNominal  = Donasi::where('status', 'valid')->sum('nominal');

        return view('admin.donasi.index', compact(
            'donasi', 'totalPending', 'totalValid', 'totalDitolak', 'totalNominal'
        ));
    }

    /**
     * Halaman tambah donasi baru (untuk admin).
     */
    public function create()
    {
        return view('admin.donasi.create');
    }

    /**
     * Simpan donasi baru dari admin.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'no_hp'        => 'nullable|string|max:20',
            'nominal'      => 'required|integer|min:1000',
            'tanggal'      => 'required|date',
            'keterangan'   => 'nullable|string|max:1000',
        ]);

        $validated['kode_donasi'] = Donasi::generateKode();
        $validated['status'] = 'valid'; // Langsung valid karena dari admin

        Donasi::create($validated);

        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil ditambahkan.');
    }

    /**
     * Detail donasi (modal / halaman detail).
     */
    public function show(Donasi $donasi)
    {
        return view('admin.donasi.show', compact('donasi'));
    }

    /**
     * Validasi donasi: ubah status ke 'valid'.
     */
    public function validasi(Donasi $donasi)
    {
        if ($donasi->status !== 'pending') {
            return back()->with('error', 'Hanya donasi berstatus pending yang bisa divalidasi.');
        }

        $donasi->update(['status' => 'valid']);

        return back()->with('success', "Donasi {$donasi->kode_donasi} berhasil divalidasi.");
    }

    /**
     * Tolak donasi: ubah status ke 'ditolak' + simpan catatan.
     */
    public function tolak(Request $request, Donasi $donasi)
    {
        if ($donasi->status !== 'pending') {
            return back()->with('error', 'Hanya donasi berstatus pending yang bisa ditolak.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $donasi->update([
            'status'        => 'ditolak',
            'catatan_admin' => $request->catatan_admin ?? 'Bukti transfer tidak valid.',
        ]);

        return back()->with('success', "Donasi {$donasi->kode_donasi} telah ditolak.");
    }

    /**
     * Hapus donasi.
     */
    public function destroy(Donasi $donasi)
    {
        // Hapus file bukti transfer jika ada
        if ($donasi->bukti_transfer) {
            Storage::disk('public')->delete($donasi->bukti_transfer);
        }

        $kode = $donasi->kode_donasi;
        $donasi->delete();

        return back()->with('success', "Donasi {$kode} berhasil dihapus.");
    }

    /**
     * Edit donasi.
     */
    public function edit(Donasi $donasi)
    {
        return view('admin.donasi.edit', compact('donasi'));
    }

    public function update(Request $request, Donasi $donasi)
    {
        $request->validate([
            'nama_donatur'  => 'required|string|max:255',
            'no_hp'         => 'nullable|string|max:20',
            'nominal'       => 'required|integer|min:1000',
            'tanggal'       => 'required|date',
            'keterangan'    => 'nullable|string|max:1000',
            'bukti_transfer'=> 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('nama_donatur', 'no_hp', 'nominal', 'tanggal', 'keterangan');

        if ($request->hasFile('bukti_transfer')) {
            if ($donasi->bukti_transfer) {
                Storage::disk('public')->delete($donasi->bukti_transfer);
            }
            $data['bukti_transfer'] = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        $donasi->update($data);
        return redirect()->route('donasi.index')->with('success', 'Data donasi berhasil diperbarui.');
    }

    /**
     * Cetak laporan donasi valid (PDF via DomPDF).
     */
    public function cetak(Request $request)
    {
        $query = Donasi::where('status', 'valid')->orderBy('tanggal', 'desc');

        // Filter tahun jika ada
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $donasi       = $query->get();
        $totalNominal = $donasi->sum('nominal');
        $tahun        = $request->tahun ?? 'Semua Tahun';

        $pdf = Pdf::loadView('donasi.cetak', compact('donasi', 'totalNominal', 'tahun'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-donasi-' . now()->format('YmdHis') . '.pdf');
    }

    /**
     * CEK STATUS DONASI — untuk donatur di web publik.
     * Cek berdasarkan kode_donasi.
     */
    public function cekStatus(Request $request)
    {
        $request->validate([
            'kode_donasi' => 'required|string',
        ]);

        $donasi = Donasi::where('kode_donasi', strtoupper($request->kode_donasi))->first();

        return view('public.cek-donasi', compact('donasi'));
    }
}