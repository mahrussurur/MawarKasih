<?php

namespace App\Http\Controllers\Pengasuh;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AnakAsuh;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnak = AnakAsuh::count();
        $totalAlumni = Alumni::count();

        // Anak asuh baru terdaftar tahun ini
        $anakTahunIni = AnakAsuh::whereYear('created_at', now()->year)
            ->latest()
            ->take(5)
            ->get();

        // Alumni yang ditambahkan tahun ini
        $alumniTahunIni = Alumni::whereYear('created_at', now()->year)
            ->latest()
            ->take(5)
            ->get();

        return view('pengasuh.dashboard', compact(
            'totalAnak', 'totalAlumni', 'anakTahunIni', 'alumniTahunIni'
        ));
    }
}
