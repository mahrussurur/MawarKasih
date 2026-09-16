<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\TransaksiKeuangan;
use Illuminate\Http\Request;

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

        return view('bendahara.dashboard', compact(
            'totalPending',
            'totalDiterima',
            'totalDitolak',
            'totalNominal',
            'donasiTerbaru',
            'nominalPerBulan',
            'saldo'
        ));
    }
}

