<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Services\LaporanKeuanganService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanKeuanganBulananController extends Controller
{
    public function __construct(protected LaporanKeuanganService $laporanService) {}

    public function index(Request $request)
    {
        $laporanQuery = LaporanKeuanganBulanan::query()->orderBy('tahun', 'desc')->orderBy('bulan', 'desc');

        if ($request->filled('status')) {
            $laporanQuery->where('status', $request->status);
        }
        
        $laporans = $laporanQuery->paginate(12);

        return view('admin.laporan-bulanan.index', compact('laporans'));
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

        return view('admin.laporan-bulanan.show', compact('laporan', 'transaksis', 'ringkasan'));
    }

    public function approve(LaporanKeuanganBulanan $laporan)
    {
        if ($laporan->status !== 'submitted') {
            return redirect()->back()->with('error', 'Hanya laporan dengan status Submitted yang dapat di-approve.');
        }

        $this->laporanService->approve($laporan, Auth::user());

        return redirect()->route('admin.laporan-bulanan.index')->with('success', 'Laporan berhasil di-approve (Final).');
    }

    public function return(Request $request, LaporanKeuanganBulanan $laporan)
    {
        if ($laporan->status !== 'submitted') {
            return redirect()->back()->with('error', 'Hanya laporan dengan status Submitted yang dapat dikembalikan.');
        }

        $request->validate([
            'catatan_return' => 'required|string|min:5'
        ], [
            'catatan_return.required' => 'Catatan pengembalian wajib diisi.'
        ]);

        $this->laporanService->return($laporan, Auth::user(), $request->catatan_return);

        return redirect()->route('admin.laporan-bulanan.index')->with('success', 'Laporan berhasil dikembalikan ke Bendahara.');
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
