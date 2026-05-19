<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class TentangController extends Controller
{
    public function profil()
    {
        return view('public.pages.tentang');
    }

    public function visiMisi()
    {
        return view('public.pages.tentang');
    }

    public function galeri()
    {
        return view('public.pages.galeri');
    }

    public function kontak()
    {
        return view('public.pages.tentang');
    }
}
