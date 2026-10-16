<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nama_sekolah_terakhir', 'like', "%{$search}%")
                  ->orWhere('pendidikan_terakhir', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10)->withQueryString();

        return view('sekretaris.alumni.index', compact('data'));
    }

    public function show(Alumni $alumni)
    {
        return view('sekretaris.alumni.show', compact('alumni'));
    }

    public function cetak()
    {
        $data = Alumni::latest()->get();
        $pdf = Pdf::loadView('sekretaris.alumni.cetak', compact('data'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream('Laporan_Data_Alumni_Mawar_Kasih.pdf');
    }
}
