<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class TentangController extends Controller
{
    public function profil()
    {
        return view('public.tentang');
    }

    public function visiMisi()
    {
        return view('public.tentang');
    }

    public function kontak()
    {
        return view('public.tentang');
    }
}
