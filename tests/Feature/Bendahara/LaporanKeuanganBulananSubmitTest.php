<?php

namespace Tests\Feature\Bendahara;

use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanKeuanganBulananSubmitTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_berhasil_mengajukan_laporan_draft_dan_mengkalkulasi_ulang(): void
    {
        $bendahara = $this->buatBendahara();

        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun'           => 2026,
            'bulan'           => 5,
            'status'          => 'draft',
            'total_pemasukan' => 0,
            'saldo_akhir'     => 0,
        ]);

        TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'nominal'      => 500000,
            'tanggal'      => '2026-05-10',
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->from(route('bendahara.laporan-bulanan.index'))
            ->actingAs($bendahara)
            ->post(route('bendahara.laporan-bulanan.submit', $laporan->id));

        $response->assertRedirect(route('bendahara.laporan-bulanan.index'));
        $response->assertSessionHas('success', 'Laporan berhasil diajukan. Transaksi pada periode ini telah dikunci.');

        $this->assertDatabaseHas('laporan_keuangan_bulanans', [
            'id'              => $laporan->id,
            'status'          => 'diajukan',
            'submitted_by'    => $bendahara->id,
            'total_pemasukan' => 500000,
            'saldo_akhir'     => 500000,
        ]);
    }

    public function test_bendahara_berhasil_mengajukan_ulang_laporan_berstatus_dikembalikan(): void
    {
        $bendahara = $this->buatBendahara();

        $laporan = LaporanKeuanganBulanan::factory()->create([
            'tahun'          => 2026,
            'bulan'          => 5,
            'status'         => 'dikembalikan',
            'catatan_return' => 'Perbaiki nominal operasional',
        ]);

        $response = $this->from(route('bendahara.laporan-bulanan.index'))
            ->actingAs($bendahara)
            ->post(route('bendahara.laporan-bulanan.submit', $laporan->id));

        $response->assertRedirect(route('bendahara.laporan-bulanan.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('laporan_keuangan_bulanans', [
            'id'           => $laporan->id,
            'status'       => 'diajukan',
            'submitted_by' => $bendahara->id,
        ]);
    }

    public function test_gagal_mengajukan_laporan_jika_status_sudah_diajukan_atau_disetujui(): void
    {
        $bendahara = $this->buatBendahara();

        foreach (['diajukan', 'disetujui'] as $index => $status) {
            $laporan = LaporanKeuanganBulanan::factory()->create([
                'tahun'  => 2026,
                'bulan'  => $index + 1,
                'status' => $status,
            ]);

            $response = $this->from(route('bendahara.laporan-bulanan.index'))
                ->actingAs($bendahara)
                ->post(route('bendahara.laporan-bulanan.submit', $laporan->id));

            $response->assertRedirect(route('bendahara.laporan-bulanan.index'));
            $response->assertSessionHas('error', 'Laporan sudah diajukan atau disetujui.');
        }
    }

    public function test_mengembalikan_404_jika_id_laporan_tidak_ditemukan(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->post(route('bendahara.laporan-bulanan.submit', 99999));

        $response->assertNotFound();
    }
}
