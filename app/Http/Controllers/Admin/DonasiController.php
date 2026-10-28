<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Services\DonasiKeuanganService;
use App\Services\ImageService;
use Illuminate\Http\Request;
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

        // Filter by status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // Search by nama donatur atau kode donasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_donatur', 'like', "%{$search}%")
                    ->orWhere('kode_donasi', 'like', "%{$search}%");
            });
        }

        $donasi = $query->paginate(10)->withQueryString();

        // Hitung total per status untuk summary cards
        $totalDonasi = Donasi::count();
        $totalPending = Donasi::where('status', 'pending')->count();
        $totalValid = Donasi::where('status', 'diterima')->count();
        $totalDitolak = Donasi::where('status', 'ditolak')->count();
        $totalNominal = Donasi::where('status', 'diterima')->sum('nominal');

        // Hitung total nominal donasi per tipe donatur (berdasarkan donasi yang diterima)
        $nominalDonaturTetap = Donasi::where('status', 'diterima')->whereNotNull('donatur_id')->sum('nominal');
        $nominalDonaturUmum = Donasi::where('status', 'diterima')->whereNull('donatur_id')->sum('nominal');

        return view('admin.donasi.index', compact(
            'donasi', 'totalDonasi', 'totalPending', 'totalValid', 'totalDitolak', 'totalNominal',
            'nominalDonaturTetap', 'nominalDonaturUmum'
        ));
    }

    // Halaman tambah donasi baru (untuk admin).
    public function create()
    {
        return view('admin.donasi.create');
    }

    // Simpan donasi baru dari admin.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_donatur' => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'no_hp'        => 'nullable|digits_between:10,15',
            'nominal'      => 'required|integer|min:1000',
            'metode_pembayaran' => 'required|string|max:50',
            'keterangan'   => 'nullable|string|max:1000',
            'bukti_transfer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request, $validated): void {
            $validated['kode_donasi'] = Donasi::generateKode();
            $validated['tanggal'] = now()->toDateString();
            $validated['status'] = 'diterima'; // Langsung diterima karena dari admin

            if ($request->hasFile('bukti_transfer')) {
                $validated['bukti_transfer'] = $this->imageService->uploadAndGenerateWebp(
                    $request->file('bukti_transfer'),
                    'bukti_transfer',
                );
            }

            $donasi = Donasi::create($validated);
            $this->donasiKeuanganService->catatPemasukan($donasi, Auth::id());
        });

        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil ditambahkan.');
    }

    // Detail donasi (modal / halaman detail).
    public function show(Donasi $donasi)
    {
        return view('admin.donasi.show', compact('donasi'));
    }

    // Validasi donasi: ubah status ke 'diterima'.
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

    // Tolak donasi: ubah status ke 'ditolak' + simpan catatan.
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

    // Hapus donasi
    public function destroy(Donasi $donasi)
    {
        if ($donasi->bukti_transfer) {
            $this->imageService->deleteImage($donasi->bukti_transfer);
        }

        $kode = $donasi->kode_donasi;

        $this->donasiKeuanganService->hapusPemasukan($donasi);
        $donasi->delete();

        return redirect()->route('donasi.index')->with('success', "Donasi {$kode} berhasil dihapus.");
    }

    // Edit donasi
    public function edit(Donasi $donasi)
    {
        return view('admin.donasi.edit', compact('donasi'));
    }

    public function update(Request $request, Donasi $donasi)
    {
        $request->validate([
            'nama_donatur'      => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'no_hp'             => 'required|string|max:20',
            'nominal'           => 'required|integer|min:1000',
            'metode_pembayaran' => 'required|string|max:50',
            'tanggal'           => 'required|date',
            'keterangan'        => 'nullable|string|max:1000',
            'bukti_transfer'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only('nama_donatur', 'email', 'no_hp', 'nominal', 'metode_pembayaran', 'tanggal', 'keterangan');

        if ($request->hasFile('bukti_transfer')) {
            $this->imageService->deleteImage($donasi->bukti_transfer);
            $data['bukti_transfer'] = $this->imageService->uploadAndGenerateWebp($request->file('bukti_transfer'), 'bukti_transfer');
        }

        $donasi->update($data);

        $this->donasiKeuanganService->syncPemasukan($donasi);

        return redirect()->route('donasi.index')->with('success', 'Data donasi berhasil diperbarui.');
    }
}
