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
        return view('public.donasi.index', compact('donatur'));
    }

    public function login()
    {
        return view('public.donasi.login');
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
        return view('public.donasi.registrasi');
    }

    public function registrasiStore(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|unique:donaturs,email',
            'no_hp'  => 'required|string|min:10|max:15|regex:/^[0-9]+$/',
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
        return view('public.donasi.rekening');
    }

    public function tutorial()
    {
        return view('public.donasi.tutorial');
    }

    public function validasi(Request $request, $kode_donasi = null)
    {
        $kode = $kode_donasi ?? $request->input('kode_donasi');
        $donasi = null;

        if ($kode) {
            $donasi = Donasi::where('kode_donasi', $kode)->first();
            if (!$donasi && $request->has('kode_donasi')) {
                return redirect()->route('public.donasi.validasi')->with('error', 'Donasi dengan kode tersebut tidak ditemukan.');
            }
        }

        return view('public.donasi.validasi', compact('donasi', 'kode'));
    }

    public function uploadBukti(Request $request, $kode_donasi)
    {
        $donasi = Donasi::where('kode_donasi', $kode_donasi)->firstOrFail();
        
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $donasi->update(['bukti_transfer' => $path]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    public function kirim(Request $request)
    {
        $donatur = session('donatur_id') ? Donatur::find(session('donatur_id')) : null;

        $rules = [
            'nominal' => 'required|integer|min:1000|max:100000000',
            'metode_pembayaran' => 'required|string|in:qris,mandiri',
            'tampilkan_nama' => 'required|string|in:nama_asli,hamba_allah,anonim',
            'keterangan' => 'nullable|string|max:500',
            'website' => 'nullable|string|max:0',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if (!$donatur) {
            $rules = array_merge($rules, [
                'nama_donatur' => 'required|string|max:255',
                'email' => 'required|email:rfc,dns|max:255',
                'no_hp' => 'required|string|min:10|max:15|regex:/^[0-9]+$/',
                'alamat' => 'nullable|string|max:1000',
            ]);
        }

        $validated = $request->validate($rules);

        if (!empty($request->input('website'))) {
            return back()->withInput()->withErrors(['website' => 'Permintaan tidak valid.']);
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        $payload = [
            'kode_donasi' => Donasi::generateKode(),
            'nominal' => $validated['nominal'],
            'tanggal' => now(),
            'bukti_transfer' => $buktiPath,
            'status' => 'pending',
            'catatan_admin' => null,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'tampilkan_nama' => $validated['tampilkan_nama'],
            'keterangan' => $validated['keterangan'] ?? null,
            'donatur_id' => $donatur?->id,
        ];

        if ($donatur) {
            $payload['nama_donatur'] = $donatur->nama;
            $payload['no_hp'] = $donatur->no_hp;
            $payload['email'] = $donatur->email;
            $payload['alamat'] = $donatur->alamat;
        } else {
            $payload['nama_donatur'] = $validated['nama_donatur'];
            $payload['no_hp'] = $validated['no_hp'];
            $payload['email'] = $validated['email'];
            $payload['alamat'] = $validated['alamat'] ?? null;
        }

        $donasi = Donasi::create($payload);

        return redirect()->route('public.donasi.validasi', ['kode_donasi' => $donasi->kode_donasi])->with('success', 'Donasi Anda berhasil!');
    }
}
