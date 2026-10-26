<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\ArsipDokumen;
use App\Models\LaporanKeuanganBulanan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDonatur = User::where('role', 'donatur')->count();
        $totalAnak = AnakAsuh::count();
        $totalAlumni = Alumni::count();
        $totalArsip = ArsipDokumen::count();
        $laporanMenungguReview = LaporanKeuanganBulanan::where('status', 'diajukan')->count();

        $laporanTerbaru = LaporanKeuanganBulanan::with(['submitter.profilPegawai'])
            ->where('status', 'diajukan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->take(5)
            ->get();

        $arsipTerbaru = ArsipDokumen::with('uploader.profilPegawai')
            ->latest()
            ->take(5)
            ->get();

        return view('ketua.dashboard', compact(
            'totalDonatur',
            'totalAnak',
            'totalAlumni',
            'totalArsip',
            'laporanMenungguReview',
            'laporanTerbaru',
            'arsipTerbaru'
        ));
    }
}
