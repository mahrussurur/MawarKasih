<?php

namespace App\Http\Controllers\Sekretaris;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Kegiatan::query()->latest();

        if ($search) {
            $query->where('nama_kegiatan', 'like', '%' . $search . '%');
        }

        $kegiatans = $query->paginate(10)->withQueryString();
        return view('sekretaris.kegiatan.index', compact('kegiatans'));
    }

    public function show(Kegiatan $kegiatan)
    {
        return view('sekretaris.kegiatan.show', compact('kegiatan'));
    }
}

