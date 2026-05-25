<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\Donatur;
use Illuminate\Http\Request;
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

        $rules = [
            'nominal' => 'required|integer|min:1000|max:100000000',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'agree' => 'required|accepted',
            'website' => 'nullable|string|max:0',
        ];

        if (!$donatur) {
            $rules = array_merge($rules, [
                'nama_donatur' => 'required|string|max:255',
                'email' => 'required|email:rfc|max:255',
                'no_hp' => 'required|string|max:20|regex:/^[0-9+()\-\s]+$/',
            ]);
        }

        $validated = $request->validate($rules);

        if (!empty($request->input('website'))) {
            return back()->withInput()->withErrors(['website' => 'Permintaan tidak valid.']);
        }

        $path = $request->file('bukti_transfer')->store('donasi', 'public');

        $payload = [
            'kode_donasi' => Donasi::generateKode(),
            'nominal' => $validated['nominal'],
            'tanggal' => now(),
            'bukti_transfer' => $path,
            'status' => 'pending',
            'catatan_admin' => null,
            'keterangan' => $donatur ? 'Donatur Tetap' : 'Guest',
            'donatur_id' => $donatur?->id,
        ];

        if ($donatur) {
            $payload['nama_donatur'] = $donatur->nama;
            $payload['no_hp'] = $donatur->no_hp;
        } else {
            $payload['nama_donatur'] = $validated['nama_donatur'];
            $payload['no_hp'] = $validated['no_hp'];
        }

        Donasi::create($payload);

        return redirect()->route('public.home')->with('success', 'Donasi Anda berhasil terkirim. Mohon tunggu validasi dari admin.');
    }
}
