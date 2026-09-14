<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\AnakAsuh;
use App\Models\User;
use App\Models\Donasi;
use App\Models\Kegiatan;

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

        return view('admin.dashboard', compact(
            'totalAnak',
            'totalPengasuh',
            'totalKegiatan',
            'totalDonatur',
            'donasiTerbaru',
            'totalDonasiPending',
            'kegiatanTerbaru',
            'donasiPerBulan'
        ));
    }
}