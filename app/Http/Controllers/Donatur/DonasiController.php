<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonasiController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

    public function index(Request $request)
    {
        $userId = Auth::id();
        $query  = Donasi::where('donatur_id', $userId)->latest();

        $activeStatus = $request->input('status', 'semua');
        if ($activeStatus !== 'semua') {
            $query->where('status', $activeStatus);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_donasi', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $donasi = $query->paginate(10)->withQueryString();

        $totalDonasi  = Donasi::where('donatur_id', $userId)->count();
        $totalPending = Donasi::where('donatur_id', $userId)->where('status', 'pending')->count();
        $totalValid   = Donasi::where('donatur_id', $userId)->where('status', 'diterima')->count();
        $totalDitolak = Donasi::where('donatur_id', $userId)->where('status', 'ditolak')->count();
        $totalNominal = Donasi::where('donatur_id', $userId)->where('status', 'diterima')->sum('nominal');

        return view('donatur.donasi.index', compact(
            'donasi', 'totalDonasi', 'totalPending',
            'totalValid', 'totalDitolak', 'totalNominal'
        ));
    }

    public function show($id)
    {
        // Ownership check: donatur hanya bisa lihat donasi miliknya
        $donasi = Donasi::where('donatur_id', Auth::id())->findOrFail($id);
        return view('donatur.donasi.show', compact('donasi'));
    }

    public function uploadBukti(Request $request, $id)
    {
        // Ownership check
        $donasi = Donasi::where('donatur_id', Auth::id())
                        ->where('status', 'pending')
                        ->findOrFail($id);

        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($donasi->bukti_transfer) {
            $this->imageService->deleteImage($donasi->bukti_transfer);
        }

        $path = $this->imageService->uploadAndGenerateWebp(
            $request->file('bukti_transfer'),
            'bukti_transfer'
        );

        $donasi->update(['bukti_transfer' => $path]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah!');
    }

}

