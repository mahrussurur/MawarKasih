<?php

namespace Tests\Feature\Donatur;

use App\Models\User;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanKeuanganBulananControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create([
            'role' => 'donatur',
        ]));
    }

    // Membuat data laporan keuangan untuk pengujian
    protected function buatLaporan(array $data = [])
    {
        return LaporanKeuanganBulanan::create(array_merge([
            'tahun' => 2026,
            'bulan' => 1,
            'saldo_awal' => 1000000,
            'total_pemasukan' => 500000,
            'total_pengeluaran' => 200000,
            'saldo_akhir' => 1300000,
            'status' => 'disetujui',
        ], $data));
    }

    // Menguji Donatur berhasil melihat daftar laporan keuangan
    public function test_donatur_berhasil_melihat_daftar_laporan_keuangan(): void
    {
        $laporanDisetujui = $this->buatLaporan();

        $laporanDraft = $this->buatLaporan([
            'tahun' => 2025,
            'bulan' => 12,
            'status' => 'draft',
        ]);

        $response = $this->get(
            route('donatur.laporan-bulanan.index')
        );

        $response->assertOk();
        $response->assertViewIs('donatur.laporan-bulanan.index');

        $response->assertViewHas('laporans', function ($laporans) use ($laporanDisetujui, $laporanDraft) {
            return $laporans->total() === 1
                && $laporans->getCollection()->contains('id', $laporanDisetujui->id)
                && !$laporans->getCollection()->contains('id', $laporanDraft->id);
        });
    }

    // Menguji Donatur melihat detail laporan dan laporan yang belum disetujui ditolak
    public function test_donatur_berhasil_melihat_detail_laporan_keuangan(): void
    {
        $laporan = $this->buatLaporan();

        // Membuat transaksi pada bulan laporan
        TransaksiKeuangan::create([
            'jenis' => 'pemasukan',
            'kategori' => 'Donasi',
            'nominal' => 500000,
            'keterangan' => 'Donasi pengujian',
            'tanggal' => '2026-01-15',
        ]);

        // Membuat transaksi di luar bulan laporan
        TransaksiKeuangan::create([
            'jenis' => 'pengeluaran',
            'kategori' => 'Operasional',
            'nominal' => 100000,
            'keterangan' => 'Pengeluaran pengujian',
            'tanggal' => '2026-02-10',
        ]);

        $response = $this->get(
            route('donatur.laporan-bulanan.show', $laporan->id)
        );

        $response->assertOk();
        $response->assertViewIs('donatur.laporan-bulanan.show');
        $response->assertViewHas('laporan');
        $response->assertViewHas('transaksis', function ($transaksis) {
            return $transaksis->count() === 1
                && $transaksis->first()->keterangan === 'Donasi pengujian';
        });
        $response->assertViewHas('ringkasan');

        // Menguji laporan yang belum disetujui
        $laporanDraft = $this->buatLaporan([
            'tahun' => 2025,
            'bulan' => 12,
            'status' => 'draft',
        ]);

        $responseDraft = $this->get(
            route('donatur.laporan-bulanan.show', $laporanDraft->id)
        );

        $responseDraft->assertForbidden();
    }
}
