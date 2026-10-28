<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanKeuanganBulananController extends Controller
{
    public function index(Request $request)
    {
        $laporans = LaporanKeuanganBulanan::where('status', 'disetujui')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('donatur.laporan-bulanan.index', compact('laporans'));
    }

    public function show(LaporanKeuanganBulanan $laporan)
    {
        // Pastikan hanya laporan yang disetujui yang bisa diakses
        abort_if($laporan->status !== 'disetujui', 403);

        $startDate = Carbon::createFromDate($laporan->tahun, $laporan->bulan, 1)->startOfMonth();
        $endDate   = $startDate->copy()->endOfMonth();

        $transaksis = TransaksiKeuangan::whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                        ->orderBy('tanggal')
                        ->get();

        $ringkasan = TransaksiKeuangan::selectRaw('kategori, jenis, SUM(nominal) as total')
                        ->whereBetween('tanggal', [$startDate->toDateString(), $endDate->toDateString()])
                        ->groupBy('kategori', 'jenis')
                        ->get();

        return view('donatur.laporan-bulanan.show', compact('laporan', 'transaksis', 'ringkasan'));
    }
}

