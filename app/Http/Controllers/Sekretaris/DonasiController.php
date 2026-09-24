<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DonasiController extends Controller
{
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
        $totalDonasi = Donasi::count();
        $totalPending = Donasi::where('status', 'pending')->count();
        $totalValid = Donasi::where('status', 'diterima')->count();
        $totalDitolak = Donasi::where('status', 'ditolak')->count();
        $totalNominal = Donasi::where('status', 'diterima')->sum('nominal');

        // Hitung total donatur (Umum dan Tetap) berdasarkan donasi yang diterima
        $jumlahDonaturUmum = Donasi::where('status', 'diterima')->whereNull('donatur_id')->distinct('nama_donatur')->count('nama_donatur');
        $jumlahDonaturTetap = Donasi::where('status', 'diterima')->whereNotNull('donatur_id')->distinct('donatur_id')->count('donatur_id');

        return view('sekretaris.donasi.index', compact(
            'donasi', 'totalDonasi', 'totalPending', 'totalValid', 'totalDitolak', 'totalNominal',
            'jumlahDonaturUmum', 'jumlahDonaturTetap'
        ));
    }

    public function show(Donasi $donasi)
    {
        return view('sekretaris.donasi.show', compact('donasi'));
    }

    public function cetak(Request $request)
    {
        $query = Donasi::where('status', 'diterima')->orderBy('tanggal', 'desc');

        // Filter tahun jika ada
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $donasi = $query->get();
        $totalNominal = $donasi->sum('nominal');
        $tahun = $request->tahun ?? 'Semua Tahun';

        $pdf = Pdf::loadView('admin.donasi.cetak', compact('donasi', 'totalNominal', 'tahun'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Data_Donasi_Mawar_Kasih.pdf');
    }
}
