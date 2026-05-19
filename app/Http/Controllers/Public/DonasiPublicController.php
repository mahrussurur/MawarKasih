<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DonasiPublicController extends Controller
{
    public function form()
    {
        $donatur = session('donatur_id') ? Donatur::find(session('donatur_id')) : null;
        return view('public.pages.donasi.index', compact('donatur'));
    }

    public function login()
    {
        return view('public.pages.donasi.login');
    }

    public function loginStore(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $donatur = Donatur::where('email', $validated['email'])->first();

        if (!$donatur || !Hash::check($validated['password'], $donatur->password)) {
            return back()->withInput()->withErrors(['email' => 'Email atau password salah.']);
        }

        session(['donatur_id' => $donatur->id]);
        return redirect()->route('public.home')->with('success', 'Login berhasil. Selamat datang kembali, ' . $donatur->nama);
    }

    public function registrasi()
    {
        return view('public.pages.donasi.registrasi');
    }

    public function registrasiStore(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|unique:donaturs,email',
            'no_hp'  => 'required|string|max:20',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $donatur = Donatur::create($validated);
        session(['donatur_id' => $donatur->id]);

        return redirect()->route('public.home')->with('success', 'Registrasi berhasil. Selamat datang, ' . $donatur->nama);
    }

    public function rekening()
    {
        return view('public.pages.donasi.rekening');
    }

    public function tutorial()
    {
        return view('public.pages.donasi.tutorial');
    }

    public function validasi()
    {
        return view('public.pages.donasi.validasi');
    }

    public function kirim(Request $request)
    {
        $donatur = session('donatur_id') ? Donatur::find(session('donatur_id')) : null;

        if (!$donatur) {
            return redirect()->route('public.donasi.registrasi')->with('error', 'Silakan registrasi terlebih dahulu sebagai donatur tetap sebelum melakukan donasi.');
        }

        $validated = $request->validate([
            'nominal'        => 'required|numeric|min:1000',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        $path = $request->file('bukti_transfer')->store('donasi', 'public');

        Donasi::create([
            'kode_donasi'    => Donasi::generateKode(),
            'nama_donatur'   => $donatur->nama,
            'no_hp'          => $donatur->no_hp,
            'nominal'        => $validated['nominal'],
            'tanggal'        => now(),
            'bukti_transfer' => $path,
            'status'         => 'pending',
            'catatan_admin'  => null,
            'keterangan'     => 'Donatur Tetap',
            'donatur_id'     => $donatur->id,
        ]);

        return redirect()->route('public.home')->with('success', 'Donasi Anda berhasil terkirim. Mohon tunggu validasi dari admin.');
    }
}
