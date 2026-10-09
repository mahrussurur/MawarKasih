<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Services\DonasiKeuanganService;
use App\Services\ImageService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonasiController extends Controller
{
    public function __construct(
        protected ImageService $imageService,
        protected DonasiKeuanganService $donasiKeuanganService,
    ) {}

    public function index(Request $request)
    {
        $query = Donasi::query()->latest();

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_donatur', 'like', "%{$search}%")
                    ->orWhere('kode_donasi', 'like', "%{$search}%");
            });
        }

        $donasi = $query->paginate(10)->withQueryString();
        $totalDonasi = Donasi::count();
        $totalPending = Donasi::where('status', 'pending')->count();
        $totalValid = Donasi::where('status', 'diterima')->count();
        $totalDitolak = Donasi::where('status', 'ditolak')->count();
        $totalNominal = Donasi::where('status', 'diterima')->sum('nominal');

        // Hitung total donatur (Umum dan Tetap) berdasarkan donasi yang diterima
        $jumlahDonaturUmum = Donasi::where('status', 'diterima')->whereNull('donatur_id')->distinct('nama_donatur')->count('nama_donatur');
        $jumlahDonaturTetap = Donasi::where('status', 'diterima')->whereNotNull('donatur_id')->distinct('donatur_id')->count('donatur_id');

        // Daftar tahun tersedia untuk filter cetak
        $tahunList = Donasi::query()
            ->whereNotNull('tanggal')
            ->orderByDesc('tanggal')
            ->pluck('tanggal')
            ->map(fn ($tanggal) => Carbon::parse($tanggal)->year)
            ->unique()
            ->values();

        return view('bendahara.donasi.index', compact(
            'donasi', 'totalDonasi', 'totalPending', 'totalValid', 'totalDitolak', 'totalNominal', 'tahunList',
            'jumlahDonaturTetap', 'jumlahDonaturUmum'
        ));
    }

    public function show(Donasi $donasi)
    {
        return view('bendahara.donasi.show', compact('donasi'));
    }

    public function create()
    {
        return view('bendahara.donasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'no_hp' => 'nullable|digits_between:10,15',
            'nominal' => 'required|integer|min:1000',
            'metode_pembayaran' => 'required|string|max:50',
            'keterangan' => 'nullable|string|max:1000',
            'bukti_transfer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request, $validated): void {
            $validated['kode_donasi'] = Donasi::generateKode();
            $validated['tanggal'] = now()->toDateString();
            $validated['status'] = 'diterima';

            if ($request->hasFile('bukti_transfer')) {
                $validated['bukti_transfer'] = $this->imageService->uploadAndGenerateWebp(
                    $request->file('bukti_transfer'),
                    'bukti_transfer',
                );
            }

            $donasi = Donasi::create($validated);
            $this->donasiKeuanganService->catatPemasukan($donasi, Auth::id());
        });

        return redirect()->route('bendahara.donasi.index')->with('success', 'Donasi berhasil ditambahkan.');
    }

    public function edit(Donasi $donasi)
    {
        return view('bendahara.donasi.edit', compact('donasi'));
    }

    public function update(Request $request, Donasi $donasi)
    {
        $validated = $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'nominal' => 'required|integer|min:1000',
            'metode_pembayaran' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:1000',
            'bukti_transfer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('bukti_transfer')) {
            $this->imageService->deleteImage($donasi->bukti_transfer);
            $validated['bukti_transfer'] = $this->imageService->uploadAndGenerateWebp(
                $request->file('bukti_transfer'),
                'bukti_transfer',
            );
        }

        $donasi->update($validated);

        $this->donasiKeuanganService->syncPemasukan($donasi);

        return redirect()->route('bendahara.donasi.index')->with('success', 'Data donasi berhasil diperbarui.');
    }

    public function destroy(Donasi $donasi)
    {
        $this->imageService->deleteImage($donasi->bukti_transfer);

        $kode = $donasi->kode_donasi;
        $donasi->delete();

        return redirect()->route('bendahara.donasi.index')->with('success', "Donasi {$kode} berhasil dihapus.");
    }

    public function validasi(Request $request, Donasi $donasi)
    {
        if ($donasi->status !== 'pending') {
            return back()->with('error', 'Hanya donasi berstatus pending yang bisa divalidasi.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($donasi, $request) {
            $donasi->update([
                'status' => 'diterima',
                'catatan_admin' => $request->catatan_admin ?? 'Donasi telah diterima. Terima kasih.',
            ]);

            $this->donasiKeuanganService->catatPemasukan($donasi, Auth::id());
        });

        return back()->with('success', "Donasi {$donasi->kode_donasi} berhasil divalidasi dan dicatat sebagai pemasukan.");
    }

    public function tolak(Request $request, Donasi $donasi)
    {
        if ($donasi->status !== 'pending') {
            return back()->with('error', 'Hanya donasi berstatus pending yang bisa ditolak.');
        }

        $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $donasi->update([
            'status' => 'ditolak',
            'catatan_admin' => $request->catatan_admin ?? 'Bukti transfer tidak valid.',
        ]);

        return back()->with('success', "Donasi {$donasi->kode_donasi} telah ditolak.");
    }

    public function cetak(Request $request)
    {
        $query = Donasi::where('status', 'diterima')->orderBy('tanggal', 'desc');

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $donasi = $query->get();
        $totalNominal = $donasi->sum('nominal');
        $tahun = $request->tahun ?? 'Semua Tahun';

        $pdf = Pdf::loadView('bendahara.donasi.cetak', compact('donasi', 'totalNominal', 'tahun'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Data_Donasi_Mawar_Kasih.pdf');
    }
}
