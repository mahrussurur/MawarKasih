<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\TransaksiKeuangan;
use App\Models\LaporanKeuanganBulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPending  = Donasi::where('status', 'pending')->count();
        $totalDiterima = Donasi::where('status', 'diterima')->count();
        $totalDitolak  = Donasi::where('status', 'ditolak')->count();
        $totalNominal  = Donasi::where('status', 'diterima')->sum('nominal');
        $donasiTerbaru = Donasi::where('status', 'pending')->latest()->take(5)->get();

        // Nominal per bulan untuk chart (tahun ini)
        $donations = Donasi::where('status', 'diterima')
                           ->whereYear('tanggal', date('Y'))
                           ->get();

        $nominalData = array_fill(1, 12, 0);
        foreach ($donations as $d) {
            if ($d->tanggal) {
                $month = $d->tanggal->format('n');
                $nominalData[$month] += $d->nominal;
            }
        }
        $nominalPerBulan = array_values($nominalData);

        $totalPemasukan = TransaksiKeuangan::where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = TransaksiKeuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $now = Carbon::now();
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
            'draft'     => LaporanKeuanganBulanan::where('status', 'draft')->count(),
            'submitted' => LaporanKeuanganBulanan::where('status', 'submitted')->count(),
            'returned'  => LaporanKeuanganBulanan::where('status', 'returned')->count(),
            'approved'  => LaporanKeuanganBulanan::where('status', 'approved')->count(),
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

