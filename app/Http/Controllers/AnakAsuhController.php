<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Jika belum pakai Model

class AnakAsuhController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari tabel anak_asuh
        $anakAsuh = DB::table('anak_asuh')->get();
        
        return view('anak_asuh.index', compact('anakAsuh'));
    }
}