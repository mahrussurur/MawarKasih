<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Services\LaporanKeuanganService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LaporanKeuanganBulananController extends Controller
{
    public function __construct(protected LaporanKeuanganService $laporanService) {}

    public function index(Request $request): View
    {
        $laporanQuery = LaporanKeuanganBulanan::query()
            ->with(['submitter.profilPegawai', 'approver.profilPegawai', 'returner.profilPegawai'])
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc');

        if ($request->filled('status')) {
            $laporanQuery->where('status', $request->status);
        }

        $laporans = $laporanQuery->paginate(12)->withQueryString();

        return view('ketua.laporan-bulanan.index', compact('laporans'));
    }

    public function show(LaporanKeuanganBulanan $laporan): View
    {
        $laporan->load(['submitter.profilPegawai', 'approver.profilPegawai', 'returner.profilPegawai']);
        [$transaksis, $ringkasan] = $this->getLaporanDetailData($laporan);

        return view('ketua.laporan-bulanan.show', compact('laporan', 'transaksis', 'ringkasan'));
    }

    public function approve(LaporanKeuanganBulanan $laporan): RedirectResponse
    {
        if ($laporan->status !== 'diajukan') {
            return redirect()->back()->with('error', 'Hanya laporan dengan status Diajukan yang dapat disetujui.');
        }

        $this->laporanService->approve($laporan, Auth::user());

        return redirect()->route('ketua.laporan-bulanan.index')->with('success', 'Laporan bulanan berhasil disetujui.');
    }

    public function return(Request $request, LaporanKeuanganBulanan $laporan): RedirectResponse
    {
        if ($laporan->status !== 'diajukan') {
            return redirect()->back()->with('error', 'Hanya laporan dengan status Diajukan yang dapat dikembalikan.');
        }

        $request->validate([
            'catatan_return' => ['required', 'string', 'min:5'],
        ], [
            'catatan_return.required' => 'Catatan pengembalian wajib diisi.',
            'catatan_return.min' => 'Catatan pengembalian minimal harus 5 karakter.',
        ]);

        $this->laporanService->return($laporan, Auth::user(), $request->catatan_return);

        return redirect()->route('ketua.laporan-bulanan.index')->with('success', 'Laporan berhasil dikembalikan ke Bendahara dengan catatan perbaikan.');
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
