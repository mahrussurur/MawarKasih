<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // Summary cards
        $totalDonasi   = Donasi::where('donatur_id', $userId)->count();
        $totalNominal  = Donasi::where('donatur_id', $userId)->where('status', 'diterima')->sum('nominal');
        $nominalBulanIni = Donasi::where('donatur_id', $userId)
                            ->where('status', 'diterima')
                            ->whereMonth('tanggal', $bulanIni)
                            ->whereYear('tanggal', $tahunIni)
                            ->sum('nominal');

        // Riwayat donasi terbaru: yang sudah diterima atau ditolak
        $donasiTerbaru = Donasi::where('donatur_id', $userId)
                            ->whereIn('status', ['diterima', 'ditolak'])
                            ->latest('tanggal')
                            ->take(5)
                            ->get();

        // Grafik donasi per bulan (nominal diterima)
        $monthlyTotals = Donasi::where('donatur_id', $userId)
            ->where('status', 'diterima')
            ->whereYear('tanggal', $tahunIni)
            ->selectRaw('MONTH(tanggal) as bulan, SUM(nominal) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $donasiPerBulan = array_map(fn ($m) => (float) ($monthlyTotals[$m] ?? 0), range(1, 12));

        return view('donatur.dashboard', compact(
            'totalDonasi',
            'totalNominal',
            'nominalBulanIni',
            'donasiTerbaru',
            'donasiPerBulan'
        ));
    }
}
