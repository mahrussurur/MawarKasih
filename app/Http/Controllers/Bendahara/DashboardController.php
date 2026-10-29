<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $totalPending  = Donasi::where('status', 'pending')->count();
        $totalDiterima = Donasi::where('status', 'diterima')->count();
        $totalDitolak  = Donasi::where('status', 'ditolak')->count();
        $totalNominal  = Donasi::where('status', 'diterima')->sum('nominal');
        $donasiTerbaru = Donasi::where('status', 'pending')->latest()->take(5)->get();

        // Nominal per bulan untuk chart (tahun ini)
        $monthlyDonations = Donasi::where('status', 'diterima')
            ->whereYear('tanggal', $now->year)
            ->selectRaw('MONTH(tanggal) as bulan, SUM(nominal) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $nominalPerBulan = array_map(fn ($m) => (float) ($monthlyDonations[$m] ?? 0), range(1, 12));

        $totalPemasukan = TransaksiKeuangan::where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = TransaksiKeuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $pemasukanBulanIni = TransaksiKeuangan::where('jenis', 'pemasukan')
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->sum('nominal');
            
        $pengeluaranBulanIni = TransaksiKeuangan::where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->sum('nominal');
            
        $saldoBulanIni = $pemasukanBulanIni - $pengeluaranBulanIni;

        $laporanCounts = [
            'draft'        => LaporanKeuanganBulanan::where('status', 'draft')->count(),
            'diajukan'     => LaporanKeuanganBulanan::where('status', 'diajukan')->count(),
            'dikembalikan' => LaporanKeuanganBulanan::where('status', 'dikembalikan')->count(),
            'disetujui'    => LaporanKeuanganBulanan::where('status', 'disetujui')->count(),
        ];

        return view('bendahara.dashboard', compact(
            'totalPending',
            'totalDiterima',
            'totalDitolak',
            'totalNominal',
            'donasiTerbaru',
            'nominalPerBulan',
            'saldo',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'saldoBulanIni',
            'laporanCounts'
        ));
    }
}

