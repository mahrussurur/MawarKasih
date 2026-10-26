<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumniController extends Controller
{
    public function index(Request $request): View
    {
        $query = Alumni::latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nama_sekolah_terakhir', 'like', "%{$search}%")
                  ->orWhere('pendidikan_terakhir', 'like', "%{$search}%");
            });
        }

        $data = $query->paginate(10)->withQueryString();

        return view('ketua.alumni.index', compact('data'));
    }

    public function show(Alumni $alumni): View
    {
        return view('ketua.alumni.show', compact('alumni'));
    }

    public function cetak()
    {
        $data = Alumni::latest()->get();
        $pdf = Pdf::loadView('ketua.alumni.cetak', compact('data'))
                  ->setPaper('a4', 'portrait');
        return $pdf->stream('Laporan_Data_Alumni_Mawar_Kasih.pdf');
    }
}
