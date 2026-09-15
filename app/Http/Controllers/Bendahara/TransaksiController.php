<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\TransaksiKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
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

        return view('bendahara.transaksi.index', compact(
            'transaksi', 'totalPemasukan', 'totalPengeluaran', 'saldo'
        ));
    }

    public function create()
    {
        return view('bendahara.transaksi.create');
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

        return redirect()->route('bendahara.transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(TransaksiKeuangan $transaksi)
    {
        // Cegah edit transaksi yang tergenerate dari donasi (optional/bisnis rule)
        if ($transaksi->donasi_id) {
            return redirect()->route('bendahara.transaksi.index')->with('error', 'Transaksi dari donasi otomatis tidak bisa diedit secara manual. Edit donasinya jika diperlukan.');
        }

        return view('bendahara.transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, TransaksiKeuangan $transaksi)
    {
        if ($transaksi->donasi_id) {
            return redirect()->route('bendahara.transaksi.index')->with('error', 'Transaksi dari donasi otomatis tidak bisa diedit secara manual.');
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

        return redirect()->route('bendahara.transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(TransaksiKeuangan $transaksi)
    {
        if ($transaksi->donasi_id) {
            return redirect()->route('bendahara.transaksi.index')->with('error', 'Transaksi dari donasi otomatis tidak bisa dihapus. Tolak donasi tersebut jika ingin membatalkan.');
        }

        $transaksi->delete();

        return redirect()->route('bendahara.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
