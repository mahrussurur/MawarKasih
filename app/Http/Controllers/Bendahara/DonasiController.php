<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Services\DonasiKeuanganService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonasiController extends Controller
{
    public function __construct(protected DonasiKeuanganService $donasiKeuanganService)
    {
    }

    public function index(Request $request)
    {
        $query = Donasi::query()->latest();

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_donatur', 'like', "%{$search}%")
                  ->orWhere('kode_donasi', 'like', "%{$search}%");
            });
        }

        $donasi       = $query->paginate(10)->withQueryString();
        $totalDonasi  = Donasi::count();
        $totalPending = Donasi::where('status', 'pending')->count();
        $totalValid   = Donasi::where('status', 'diterima')->count();
        $totalDitolak = Donasi::where('status', 'ditolak')->count();
        $totalNominal = Donasi::where('status', 'diterima')->sum('nominal');

        // Hitung total donatur (Umum dan Tetap) berdasarkan donasi yang diterima
        $jumlahDonaturUmum  = Donasi::where('status', 'diterima')->whereNull('donatur_id')->distinct('nama_donatur')->count('nama_donatur');
        $jumlahDonaturTetap = Donasi::where('status', 'diterima')->whereNotNull('donatur_id')->distinct('donatur_id')->count('donatur_id');

        // Daftar tahun tersedia untuk filter cetak
        $tahunList = Donasi::selectRaw('YEAR(tanggal) as tahun')
                          ->distinct()
                          ->orderByDesc('tahun')
                          ->pluck('tahun')
                          ->filter();

        return view('bendahara.donasi.index', compact(
            'donasi', 'totalDonasi', 'totalPending', 'totalValid', 'totalDitolak', 'totalNominal', 'tahunList',
            'jumlahDonaturTetap', 'jumlahDonaturUmum'
        ));
    }

    public function show(Donasi $donasi)
    {
        return view('bendahara.donasi.show', compact('donasi'));
    }

    public function validasi(Request $request, Donasi $donasi)
    {
        if ($donasi->status !== 'pending') {
            return back()->with('error', 'Hanya donasi berstatus pending yang bisa divalidasi.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($donasi, $request) {
            $donasi->update([
                'status'        => 'diterima',
                'catatan_admin' => $request->catatan_admin ?? 'Donasi telah diterima. Terima kasih.',
                'verified_by'   => Auth::id(),
                'verified_at'   => now(),
            ]);

            $this->donasiKeuanganService->catatPemasukan($donasi, Auth::id());
        });

        return back()->with('success', "Donasi {$donasi->kode_donasi} berhasil divalidasi dan dicatat sebagai pemasukan.");
    }

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
            'verified_by'   => Auth::id(),
            'verified_at'   => now(),
        ]);

        return back()->with('success', "Donasi {$donasi->kode_donasi} telah ditolak.");
    }

    public function cetak(Request $request)
    {
        $query = Donasi::where('status', 'diterima')->orderBy('tanggal', 'desc');

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $donasi       = $query->get();
        $totalNominal = $donasi->sum('nominal');
        $tahun        = $request->tahun ?? 'Semua Tahun';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bendahara.donasi.cetak', compact('donasi', 'totalNominal', 'tahun'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Data_Donasi_Mawar_Kasih.pdf');
    }
}
