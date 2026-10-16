<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\Donasi;
use App\Models\Kegiatan;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnak = AnakAsuh::count();
        $totalAlumni = Alumni::count();
        $totalPengelola = User::whereIn('role', ['pengasuh', 'bendahara', 'sekretaris'])->count();
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
                $donasiPerBulanData[$month] += $donasi->nominal;
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

        $laporanMenungguApproval = LaporanKeuanganBulanan::where('status', 'diajukan')->count();
        $laporanTerbaru = LaporanKeuanganBulanan::with(['submitter.profilPengelola'])
            ->where('status', 'diajukan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalAnak',
            'totalAlumni',
            'totalPengelola',
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
