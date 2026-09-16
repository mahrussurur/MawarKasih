<?php

namespace App\Http\Controllers\Pengasuh;

use App\Http\Controllers\Controller;
use App\Models\AnakAsuh;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnak = AnakAsuh::count();
        $anakTerbaru = AnakAsuh::latest()->take(5)->get();
        return view('pengasuh.dashboard', compact('totalAnak', 'anakTerbaru'));
    }
}
