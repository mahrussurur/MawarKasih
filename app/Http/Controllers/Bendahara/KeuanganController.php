<?php

namespace App\Http\Controllers\Bendahara;

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

        return redirect()->route('bendahara.keuangan.index')->with('success', 'Data Keuangan berhasil ditambahkan.');
    }

    public function edit(TransaksiKeuangan $keuangan)
    {
        if ($keuangan->donasi_id) {
            return redirect()->route('bendahara.keuangan.index')->with('error', 'Data keuangan dari donasi otomatis tidak bisa diedit secara manual. Edit donasinya jika diperlukan.');
        }

        return view('bendahara.keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, TransaksiKeuangan $keuangan)
    {
        if ($keuangan->donasi_id) {
            return redirect()->route('bendahara.keuangan.index')->with('error', 'Data keuangan dari donasi otomatis tidak bisa diedit secara manual.');
        }

        $request->validate([
            'jenis'      => 'required|in:pemasukan,pengeluaran',
            'nominal'    => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
            'tanggal'    => 'required|date',
        ]);

        $keuangan->update([
            'jenis'      => $request->jenis,
            'nominal'    => $request->nominal,
            'keterangan' => $request->keterangan,
            'tanggal'    => $request->tanggal,
        ]);

        return redirect()->route('bendahara.keuangan.index')->with('success', 'Data Keuangan berhasil diperbarui.');
    }

    public function destroy(TransaksiKeuangan $keuangan)
    {
        if ($keuangan->donasi_id) {
            return redirect()->route('bendahara.keuangan.index')->with('error', 'Data keuangan dari donasi otomatis tidak bisa dihapus. Tolak donasi tersebut jika ingin membatalkan.');
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
