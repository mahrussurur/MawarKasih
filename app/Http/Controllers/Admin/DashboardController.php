<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\AnakAsuh;
use App\Models\User;
use App\Models\Donasi;
use App\Models\Kegiatan;
use App\Models\TransaksiKeuangan;
use App\Models\LaporanKeuanganBulanan;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnak = AnakAsuh::count();
        $totalPengasuh = User::where('role', 'pengasuh')->count();
        $totalKegiatan = Kegiatan::count();
        $totalDonatur = User::where('role', 'donatur')->count();

        $donasiTerbaru  = Donasi::where('status', 'pending')->latest()->take(5)->get();
        $totalDonasiPending = Donasi::where('status', 'pending')->count();
        $kegiatanTerbaru = Kegiatan::latest()->take(5)->get();

        $donations = Donasi::where('status', 'diterima')
            ->whereYear('tanggal', date('Y'))
            ->get();
            
        $donasiPerBulanData = array_fill(1, 12, 0);
        foreach ($donations as $donasi) {
            if ($donasi->tanggal) {
                $month = $donasi->tanggal->format('n');
                $donasiPerBulanData[$month] += 1;
            }
        }
        $donasiPerBulan = array_values($donasiPerBulanData);

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

        $totalPemasukan = TransaksiKeuangan::where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = TransaksiKeuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $saldoSaatIni = $totalPemasukan - $totalPengeluaran;

        $laporanMenungguApproval = LaporanKeuanganBulanan::where('status', 'submitted')->count();
        $laporanTerbaru = LaporanKeuanganBulanan::with('submitter')->latest('tahun')->latest('bulan')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalAnak',
            'totalPengasuh',
            'totalKegiatan',
            'totalDonatur',
            'donasiTerbaru',
            'totalDonasiPending',
            'kegiatanTerbaru',
            'donasiPerBulan',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'saldoBulanIni',
            'saldoSaatIni',
            'laporanMenungguApproval',
            'laporanTerbaru'
        ));
    }
}