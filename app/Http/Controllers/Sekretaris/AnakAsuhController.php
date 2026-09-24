<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\AnakAsuh;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AnakAsuhController extends Controller
{
    public function index(Request $request)
    {
        $query = AnakAsuh::latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nama_panggilan', 'like', "%{$search}%")
                  ->orWhere('nama_ayah', 'like', "%{$search}%")
                  ->orWhere('nama_ibu', 'like', "%{$search}%")
                  ->orWhere('sekolah', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10)->withQueryString();
        $totalData = AnakAsuh::count();

        return view('sekretaris.anak_asuh.index', compact('data', 'totalData'));
    }

    public function show(AnakAsuh $anakAsuh)
    {
        return view('sekretaris.anak_asuh.show', compact('anakAsuh'));
    }

    public function cetak()
    {
        $data = AnakAsuh::all();
        $pdf = Pdf::loadView('admin.anak_asuh.cetak', compact('data'));
        return $pdf->stream('Laporan_Data_Anak_Asuh_Mawar_Kasih.pdf');
    }
}
