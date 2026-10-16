<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\TransaksiKeuangan;
use App\Models\LaporanKeuanganBulanan;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;

class KeuanganController extends Controller
{
    public function __construct(protected ImageService $imageService) {}

    private function isPeriodLocked($tanggal): bool
    {
        $date = Carbon::parse($tanggal);
        $laporan = LaporanKeuanganBulanan::where('tahun', $date->year)->where('bulan', $date->month)->first();
        return $laporan && in_array($laporan->status, ['diajukan', 'disetujui']);
    }

    public function index(Request $request)
    {
        $query = TransaksiKeuangan::query()->latest('tanggal')->latest('id');

        if ($request->filled('jenis') && $request->jenis !== 'semua') {
            $query->where('jenis', $request->jenis);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('keterangan', 'like', "%{$search}%");
        }

        $keuangan = $query->paginate(10)->withQueryString();
        
        $totalPemasukan = TransaksiKeuangan::where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = TransaksiKeuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('bendahara.keuangan.index', compact(
            'keuangan', 'totalPemasukan', 'totalPengeluaran', 'saldo'
        ));
    }

    public function create()
    {
        return view('bendahara.keuangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis'      => 'required|in:pemasukan,pengeluaran',
            'kategori'   => 'required|string|in:DONASI,PENDIDIKAN,KONSUMSI,KESEHATAN,OPERASIONAL,TRANSPORTASI,GAJI,LAINNYA',
            'nominal'    => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'bukti_transaksi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($this->isPeriodLocked($request->tanggal)) {
            return redirect()->back()->withInput()->with('error', 'Transaksi tidak dapat ditambah karena laporan keuangan pada bulan tersebut sudah dikunci (Diajukan/Disetujui).');
        }

        $data = [
            'jenis'        => $request->jenis,
            'kategori'     => $request->kategori,
            'nominal'      => $request->nominal,
            'keterangan'   => $request->keterangan,
            'tanggal'      => $request->tanggal,
            'dicatat_oleh' => Auth::id(),
        ];

        if ($request->hasFile('bukti_transaksi')) {
            $data['bukti_transaksi'] = $this->imageService->uploadAndGenerateWebp(
                $request->file('bukti_transaksi'),
                'bukti_transaksi',
            );
        }

        TransaksiKeuangan::create($data);

        return redirect()->route('bendahara.keuangan.index')->with('success', 'Data Keuangan berhasil ditambahkan.');
    }

    public function edit(TransaksiKeuangan $keuangan)
    {
        if ($keuangan->donasi_id || $keuangan->kategori === 'DONASI') {
            return redirect()->route('bendahara.keuangan.index')->with('error', 'Data keuangan dari donasi tidak bisa diedit secara manual. Edit donasinya jika diperlukan.');
        }

        return view('bendahara.keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, TransaksiKeuangan $keuangan)
    {
        if ($keuangan->donasi_id || $keuangan->kategori === 'DONASI') {
            return redirect()->route('bendahara.keuangan.index')->with('error', 'Data keuangan dari donasi tidak bisa diedit secara manual.');
        }

        $validated = $request->validate([
            'jenis'      => 'required|in:pemasukan,pengeluaran',
            'kategori'   => 'required|string|in:DONASI,PENDIDIKAN,KONSUMSI,KESEHATAN,OPERASIONAL,TRANSPORTASI,GAJI,LAINNYA',
            'nominal'    => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
            'tanggal'    => 'required|date',
            'bukti_transaksi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($this->isPeriodLocked($keuangan->tanggal) || $this->isPeriodLocked($request->tanggal)) {
            return redirect()->back()->withInput()->with('error', 'Transaksi tidak dapat diubah karena laporan keuangan pada bulan lama atau baru sudah dikunci.');
        }

        $data = $request->only('jenis', 'kategori', 'nominal', 'keterangan', 'tanggal');

        if ($request->hasFile('bukti_transaksi')) {
            if ($keuangan->bukti_transaksi) {
                $this->imageService->deleteImage($keuangan->bukti_transaksi);
            }
            $data['bukti_transaksi'] = $this->imageService->uploadAndGenerateWebp(
                $request->file('bukti_transaksi'),
                'bukti_transaksi',
            );
        }

        $keuangan->update($data);

        return redirect()->route('bendahara.keuangan.index')->with('success', 'Data Keuangan berhasil diperbarui.');
    }

    public function destroy(TransaksiKeuangan $keuangan)
    {
        if ($keuangan->donasi_id || $keuangan->kategori === 'DONASI') {
            return redirect()->route('bendahara.keuangan.index')->with('error', 'Data keuangan dari donasi tidak bisa dihapus dari menu keuangan. Hapus atau tolak data donasinya jika ingin membatalkan.');
        }

        if ($this->isPeriodLocked($keuangan->tanggal)) {
            return redirect()->back()->with('error', 'Transaksi tidak dapat dihapus karena laporan keuangan pada bulan tersebut sudah dikunci.');
        }

        if ($keuangan->bukti_transaksi) {
            $this->imageService->deleteImage($keuangan->bukti_transaksi);
        }

        $keuangan->delete();

        return redirect()->route('bendahara.keuangan.index')->with('success', 'Data Keuangan berhasil dihapus.');
    }

    public function cetak(Request $request)
    {
        $query = TransaksiKeuangan::query()->orderBy('tanggal', 'desc')->orderBy('id', 'desc');

        $jenis = $request->get('jenis', 'semua');
        if (in_array($jenis, ['pemasukan', 'pengeluaran'], true)) {
            $query->where('jenis', $jenis);
        }

        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $keuangan   = $query->get();
        $tahun      = $request->tahun ?? 'Semua Tahun';
        $jenisLabel = match($jenis) {
            'pemasukan'   => 'Pemasukan',
            'pengeluaran' => 'Pengeluaran',
            default       => 'Semua Data Keuangan',
        };

        $pdf = Pdf::loadView('bendahara.keuangan.cetak', compact('keuangan', 'tahun', 'jenisLabel'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Keuangan_Mawar_Kasih.pdf');
    }
}
