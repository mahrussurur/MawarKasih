<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\AnakAsuh;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnakAsuhController extends Controller
{
    public function index(Request $request): View
    {
        $query = AnakAsuh::latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nama_panggilan', 'like', "%{$search}%")
                  ->orWhere('nama_ibu', 'like', "%{$search}%")
                  ->orWhere('sekolah', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10)->withQueryString();
        $totalData = AnakAsuh::count();

        return view('ketua.anak_asuh.index', compact('data', 'totalData'));
    }

    public function show(AnakAsuh $anakAsuh): View
    {
        return view('ketua.anak_asuh.show', compact('anakAsuh'));
    }

    public function cetak()
    {
        $data = AnakAsuh::all();
        $pdf = Pdf::loadView('admin.anak_asuh.cetak', compact('data'));
        return $pdf->stream('Laporan_Data_Anak_Asuh_Mawar_Kasih.pdf');
    }
}
