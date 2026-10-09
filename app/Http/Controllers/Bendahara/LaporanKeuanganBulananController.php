<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuanganBulanan;
use App\Services\LaporanKeuanganService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanKeuanganBulananController extends Controller
{
    public function __construct(protected LaporanKeuanganService $laporanService) {}

    public function index(Request $request)
    {
        $tahun = $request->get('tahun', Carbon::now()->year);
        $bulan = $request->get('bulan', Carbon::now()->month);

        $laporan = $this->laporanService->getOrCreateDraft($tahun, $bulan);

        return view('bendahara.laporan-bulanan.index', compact('laporan', 'tahun', 'bulan'));
    }

    public function submit(Request $request, LaporanKeuanganBulanan $laporan)
    {
        if (in_array($laporan->status, ['submitted', 'approved'])) {
            return redirect()->back()->with('error', 'Laporan sudah disubmit atau diapprove.');
        }

        $this->laporanService->submit($laporan, Auth::user());

        return redirect()->back()->with('success', 'Laporan berhasil disubmit. Transaksi pada periode ini telah dikunci.');
    }

    public function cetak(LaporanKeuanganBulanan $laporan)
    {
        $transaksis = \App\Models\TransaksiKeuangan::whereYear('tanggal', $laporan->tahun)
            ->whereMonth('tanggal', $laporan->bulan)
            ->orderBy('tanggal', 'asc')
            ->get();
            
        $ringkasan = \App\Models\TransaksiKeuangan::selectRaw('jenis, kategori, SUM(nominal) as total')
            ->whereYear('tanggal', $laporan->tahun)
            ->whereMonth('tanggal', $laporan->bulan)
            ->groupBy('jenis', 'kategori')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan-bulanan.cetak', compact('laporan', 'transaksis', 'ringkasan'));
        return $pdf->stream('Laporan_Bulanan_' . $laporan->tahun . '_' . str_pad($laporan->bulan, 2, '0', STR_PAD_LEFT) . '.pdf');
    }
}
