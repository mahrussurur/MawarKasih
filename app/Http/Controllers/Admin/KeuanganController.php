<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class KeuanganController extends Controller
{
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

        $transaksi = $query->paginate(10)->withQueryString();
        
        $totalPemasukan = TransaksiKeuangan::where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = TransaksiKeuangan::where('jenis', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('admin.keuangan.index', compact(
            'transaksi', 'totalPemasukan', 'totalPengeluaran', 'saldo'
        ));
    }

    public function create()
    {
        return view('admin.keuangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'      => 'required|in:pemasukan,pengeluaran',
            'nominal'    => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
            'tanggal'    => 'required|date',
        ]);

        TransaksiKeuangan::create([
            'jenis'        => $request->jenis,
            'nominal'      => $request->nominal,
            'keterangan'   => $request->keterangan,
            'tanggal'      => $request->tanggal,
            'dicatat_oleh' => Auth::id(),
        ]);

        return redirect()->route('admin.keuangan.index')->with('success', 'Data Keuangan berhasil ditambahkan.');
    }

    public function edit(TransaksiKeuangan $transaksi)
    {
        // Cegah edit transaksi yang tergenerate dari donasi (optional/bisnis rule)
        if ($transaksi->donasi_id) {
            return redirect()->route('admin.keuangan.index')->with('error', 'Data keuangan dari donasi otomatis tidak bisa diedit secara manual. Edit donasinya jika diperlukan.');
        }

        return view('admin.keuangan.edit', compact('transaksi'));
    }

    public function update(Request $request, TransaksiKeuangan $transaksi)
    {
        if ($transaksi->donasi_id) {
            return redirect()->route('admin.keuangan.index')->with('error', 'Data keuangan dari donasi otomatis tidak bisa diedit secara manual.');
        }

        $request->validate([
            'jenis'      => 'required|in:pemasukan,pengeluaran',
            'nominal'    => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
            'tanggal'    => 'required|date',
        ]);

        $transaksi->update([
            'jenis'      => $request->jenis,
            'nominal'    => $request->nominal,
            'keterangan' => $request->keterangan,
            'tanggal'    => $request->tanggal,
        ]);

        return redirect()->route('admin.keuangan.index')->with('success', 'Data Keuangan berhasil diperbarui.');
    }

    public function destroy(TransaksiKeuangan $transaksi)
    {
        if ($transaksi->donasi_id) {
            return redirect()->route('admin.keuangan.index')->with('error', 'Data keuangan dari donasi otomatis tidak bisa dihapus. Tolak donasi tersebut jika ingin membatalkan.');
        }

        $transaksi->delete();

        return redirect()->route('admin.keuangan.index')->with('success', 'Data Keuangan berhasil dihapus.');
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

        $transaksi  = $query->get();
        $tahun      = $request->tahun ?? 'Semua Tahun';
        $jenisLabel = match($jenis) {
            'pemasukan'   => 'Pemasukan',
            'pengeluaran' => 'Pengeluaran',
            default       => 'Semua Transaksi',
        };

        $pdf = Pdf::loadView('admin.keuangan.cetak', compact('transaksi', 'tahun', 'jenisLabel'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Keuangan_Mawar_Kasih.pdf');
    }
}
