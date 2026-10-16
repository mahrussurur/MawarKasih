<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDonasi = Donasi::where('donatur_id', Auth::id())->count();
        $totalNominal = Donasi::where('donatur_id', Auth::id())->where('status', 'diterima')->sum('nominal');
        $donasiTerbaru = Donasi::where('donatur_id', Auth::id())->latest()->take(5)->get();

        return view('donatur.dashboard', compact('totalDonasi', 'totalNominal', 'donasiTerbaru'));
    }
}
