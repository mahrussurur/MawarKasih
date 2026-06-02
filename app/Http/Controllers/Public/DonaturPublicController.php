<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Donatur;
use Illuminate\Http\Request;

class DonaturPublicController extends Controller
{
    protected function currentDonatur()
    {
        if (!session()->has('donatur_id')) {
            return null;
        }

        return Donatur::find(session('donatur_id'));
    }

    public function profile()
    {
        $donatur = $this->currentDonatur();
        if (!$donatur) {
            return redirect()->route('public.donasi.registrasi')->with('error', 'Silakan registrasi terlebih dahulu.');
        }

        return view('public.donatur.profile', compact('donatur'));
    }

    public function history()
    {
        $donatur = $this->currentDonatur();
        if (!$donatur) {
            return redirect()->route('public.donasi.registrasi')->with('error', 'Silakan registrasi terlebih dahulu.');
        }

        $donasis = Donasi::where('donatur_id', $donatur->id)
            ->latest('tanggal')
            ->get();

        return view('public.donatur.history', compact('donatur', 'donasis'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('donatur_id');
        return redirect()->route('public.home')->with('success', 'Anda telah logout dari akun donatur.');
    }
}
