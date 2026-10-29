<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\Donasi;
use App\Models\ProfilPegawai;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $totalAnak = AnakAsuh::count();
        $totalAlumni = Alumni::count();
        $totalPegawai = ProfilPegawai::count();
        $totalDonatur = User::where('role', 'donatur')->count();

        $donasiTerbaru = Donasi::where('status', 'pending')->latest()->take(5)->get();
        $totalDonasiPending = Donasi::where('status', 'pending')->count();

        $monthlyDonations = Donasi::where('status', 'diterima')
            ->whereYear('tanggal', $now->year)
            ->selectRaw('MONTH(tanggal) as bulan, SUM(nominal) as total')
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $donasiPerBulan = array_map(fn ($m) => (float) ($monthlyDonations[$m] ?? 0), range(1, 12));

        $pemasukanBulanIni = TransaksiKeuangan::where('jenis', 'pemasukan')
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->sum('nominal');
            
        $pengeluaranBulanIni = TransaksiKeuangan::where('jenis', 'pengeluaran')
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->sum('nominal');
            
        $saldoBulanIni = $pemasukanBulanIni - $pengeluaranBulanIni;

        $totalPemasukan = TransaksiKeuangan::where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = TransaksiKeuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $saldoSaatIni = $totalPemasukan - $totalPengeluaran;

        return view('admin.dashboard', compact(
            'totalAnak',
            'totalAlumni',
            'totalPegawai',
            'totalDonatur',
            'donasiTerbaru',
            'totalDonasiPending',
            'donasiPerBulan',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'saldoBulanIni',
            'saldoSaatIni'
        ));
    }
}
