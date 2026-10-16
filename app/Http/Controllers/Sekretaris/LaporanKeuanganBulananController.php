<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanKeuanganBulananController extends Controller
{
    public function index(Request $request)
    {
        $laporanQuery = LaporanKeuanganBulanan::query()->orderBy('tahun', 'desc')->orderBy('bulan', 'desc');

        if ($request->filled('status')) {
            $laporanQuery->where('status', $request->status);
        }
        
        $laporans = $laporanQuery->paginate(12);

        return view('sekretaris.laporan-bulanan.index', compact('laporans'));
    }

    public function show(LaporanKeuanganBulanan $laporan)
    {
        $startDate = Carbon::createFromDate($laporan->tahun, $laporan->bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $transaksis = TransaksiKeuangan::whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                        ->orderBy('tanggal')
                        ->get();

        $ringkasan = TransaksiKeuangan::selectRaw('kategori, jenis, SUM(nominal) as total')
                        ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                        ->groupBy('kategori', 'jenis')
                        ->get();

        return view('sekretaris.laporan-bulanan.show', compact('laporan', 'transaksis', 'ringkasan'));
    }

    public function cetak(LaporanKeuanganBulanan $laporan)
    {
        $startDate = Carbon::createFromDate($laporan->tahun, $laporan->bulan, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $transaksis = TransaksiKeuangan::whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                        ->orderBy('tanggal')
                        ->get();

        $ringkasan = TransaksiKeuangan::selectRaw('kategori, jenis, SUM(nominal) as total')
                        ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                        ->groupBy('kategori', 'jenis')
                        ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan-bulanan.cetak', compact('laporan', 'transaksis', 'ringkasan'));
        return $pdf->stream('Laporan_Bulanan_' . $laporan->tahun . '_' . str_pad($laporan->bulan, 2, '0', STR_PAD_LEFT) . '.pdf');
    }
}
