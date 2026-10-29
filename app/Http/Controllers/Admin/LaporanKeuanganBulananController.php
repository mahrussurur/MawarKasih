<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use Barryvdh\DomPDF\Facade\Pdf;
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
        
        $laporans = $laporanQuery->paginate(12)->withQueryString();

        return view('admin.laporan-bulanan.index', compact('laporans'));
    }

    public function show(LaporanKeuanganBulanan $laporan)
    {
        [$transaksis, $ringkasan] = $this->getLaporanDetailData($laporan);

        return view('admin.laporan-bulanan.show', compact('laporan', 'transaksis', 'ringkasan'));
    }

    public function cetak(LaporanKeuanganBulanan $laporan)
    {
        [$transaksis, $ringkasan] = $this->getLaporanDetailData($laporan);

        $pdf = Pdf::loadView('laporan-bulanan.cetak', compact('laporan', 'transaksis', 'ringkasan'));
        return $pdf->stream('Laporan_Bulanan_' . $laporan->tahun . '_' . str_pad($laporan->bulan, 2, '0', STR_PAD_LEFT) . '.pdf');
    }

    private function getLaporanDetailData(LaporanKeuanganBulanan $laporan): array
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

        return [$transaksis, $ringkasan];
    }
}

