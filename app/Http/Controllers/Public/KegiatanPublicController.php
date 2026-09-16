<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kegiatan;

class KegiatanPublicController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Kegiatan::query();

        if ($search) {
            $query->where('nama_kegiatan', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
        }

        // Urutkan dari yang terbaru berdasarkan tanggal pelaksanaan
        $kegiatans = $query->orderBy('tanggal_pelaksanaan', 'desc')->paginate(9);

        return view('public.kegiatan.index', compact('kegiatans', 'search'));
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        
        // Ambil postingan terbaru (selain kegiatan ini)
        $recent_kegiatans = Kegiatan::where('id', '!=', $id)
                            ->orderBy('tanggal_pelaksanaan', 'desc')
                            ->limit(5)
                            ->get();

        // Ambil donasi yang valid (diterima)
        $donaturs = \App\Models\Donasi::where('status', 'diterima')
                            ->orderBy('tanggal', 'desc')
                            ->limit(50)
                            ->get();

        return view('public.kegiatan.show', compact('kegiatan', 'recent_kegiatans', 'donaturs'));
    }
}
