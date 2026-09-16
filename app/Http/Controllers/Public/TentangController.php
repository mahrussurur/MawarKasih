<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class TentangController extends Controller
{
    public function profil()
    {
        return view('public.tentang.profil');
    }

    public function visiMisi()
    {
        return view('public.tentang.visi-misi');
    }

    public function kontak()
    {
        return view('public.tentang.kontak');
    }
}
