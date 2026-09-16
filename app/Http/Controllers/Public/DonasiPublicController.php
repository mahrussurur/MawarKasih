<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;

class DonasiPublicController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function form(Request $request)
    {
        return view('public.donasi.index', [
            'donatur' => $this->authenticatedDonatur($request),
        ]);
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
            if (! $donasi && $request->has('kode_donasi')) {
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
            if ($donasi->bukti_transfer) {
                $this->imageService->deleteImage($donasi->bukti_transfer);
            }
            $path = $this->imageService->uploadAndGenerateWebp($request->file('bukti_transfer'), 'bukti_transfer');
            $donasi->update(['bukti_transfer' => $path]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    public function kirim(Request $request)
    {
        $donatur = $this->authenticatedDonatur($request);
        $profilDonatur = $donatur?->profilDonatur;

        if ($donatur && (! $profilDonatur || blank($profilDonatur->nama) || blank($profilDonatur->no_hp))) {
            return redirect()->route('profile.edit')
                ->with('error', 'Lengkapi nama dan nomor HP pada profil Anda sebelum membuat donasi.');
        }

        $rules = [
            'nominal' => 'required|integer|min:1000|max:100000000',
            'metode_pembayaran' => 'required|string|in:qris,mandiri',
            'tampilkan_nama' => 'required|string|in:nama_asli,hamba_allah,anonim',
            'keterangan' => 'nullable|string|max:500',
            'website' => 'nullable|string|max:0',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        // Donatur tetap memakai identitas profil yang tersimpan di server.
        // Field identitas hanya wajib divalidasi untuk donasi guest.
        if (! $donatur) {
            $rules = [
                ...$rules,
                'nama_donatur' => 'required|string|max:255',
                'email' => 'required|email:rfc|max:255',
                'no_hp' => 'required|string|min:10|max:15|regex:/^[0-9]+$/',
                'alamat' => 'nullable|string|max:1000',
            ];
        }

        $messages = [
            'nominal.required' => 'Nominal donasi wajib diisi.',
            'nominal.integer' => 'Nominal donasi harus berupa angka valid.',
            'nominal.min' => 'Nominal donasi minimal Rp 1.000.',
            'nominal.max' => 'Nominal donasi maksimal Rp 100.000.000.',
            'metode_pembayaran.required' => 'Silakan pilih metode pembayaran terlebih dahulu.',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid.',
            'tampilkan_nama.required' => 'Silakan pilih opsi tampilan nama untuk donasi ini.',
            'tampilkan_nama.in' => 'Opsi tampilan nama tidak valid.',
            'keterangan.max' => 'Doa/Keterangan maksimal 500 karakter.',
            'bukti_transfer.image' => 'File bukti transfer harus berupa gambar.',
            'bukti_transfer.mimes' => 'Format bukti transfer harus jpeg, png, atau jpg.',
            'bukti_transfer.max' => 'Ukuran file maksimal 2MB.',

            'nama_donatur.required' => 'Nama donatur wajib diisi.',
            'nama_donatur.max' => 'Nama donatur maksimal 255 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Alamat email maksimal 255 karakter.',
            'no_hp.required' => 'Nomor handphone wajib diisi.',
            'no_hp.min' => 'Nomor handphone minimal 10 digit.',
            'no_hp.max' => 'Nomor handphone maksimal 15 digit.',
            'no_hp.regex' => 'Nomor handphone hanya boleh berisi angka.',
            'alamat.max' => 'Alamat maksimal 1000 karakter.',
        ];

        $validated = $request->validate($rules, $messages);

        if (! empty($request->input('website'))) {
            return back()->withInput()->withErrors(['website' => 'Permintaan tidak valid.']);
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $this->imageService->uploadAndGenerateWebp($request->file('bukti_transfer'), 'bukti_transfer');
        }

        $identitasDonasi = $donatur
            ? [
                'donatur_id' => $donatur->id,
                'nama_donatur' => $profilDonatur->nama,
                'email' => $donatur->email,
                'no_hp' => $profilDonatur->no_hp,
                'alamat' => $profilDonatur->alamat,
            ]
            : [
                'donatur_id' => null,
                'nama_donatur' => $validated['nama_donatur'],
                'email' => $validated['email'],
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'] ?? null,
            ];

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
            ...$identitasDonasi,
        ];

        $donasi = Donasi::create($payload);

        return redirect()->route('public.donasi.validasi', ['kode_donasi' => $donasi->kode_donasi])->with('success', 'Donasi Anda berhasil!');
    }

    private function authenticatedDonatur(Request $request): ?User
    {
        $user = $request->user();

        if (! $user || $user->role !== 'donatur') {
            return null;
        }

        return $user->loadMissing('profilDonatur');
    }
}
