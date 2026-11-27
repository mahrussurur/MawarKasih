<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KeuanganDestroyTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_berhasil_menghapus_transaksi_keuangan_beserta_bukti_transaksi(): void
    {
        $bendahara = $this->buatBendahara();
        $transaksi = TransaksiKeuangan::factory()->create([
            'jenis'           => 'pengeluaran',
            'kategori'        => 'OPERASIONAL',
            'tanggal'         => '2026-05-10',
            'bukti_transaksi' => 'original/bukti_transaksi/hapus.jpg',
            'donasi_id'       => null,
            'dicatat_oleh'    => $bendahara->id,
        ]);

        $deletedPaths = [];
        $fakeImageService = new class($deletedPaths) extends ImageService {
            public function __construct(private array &$deletedPaths) {}
            public function deleteImage(?string $originalPath): void
            {
                $this->deletedPaths[] = $originalPath;
            }
        };
        $this->app->instance(ImageService::class, $fakeImageService);

        $response = $this->actingAs($bendahara)->delete(route('bendahara.keuangan.destroy', $transaksi->id));

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $response->assertSessionHas('success', 'Data Keuangan berhasil dihapus.');
        $this->assertSame(['original/bukti_transaksi/hapus.jpg'], $deletedPaths);
        $this->assertDatabaseMissing('transaksi_keuangans', ['id' => $transaksi->id]);
    }

    public function test_gagal_menghapus_transaksi_jika_berasal_dari_donasi(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create();

        $transaksi = TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'donasi_id'    => $donasi->id,
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->delete(route('bendahara.keuangan.destroy', $transaksi->id));

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('transaksi_keuangans', ['id' => $transaksi->id]);
    }

    public function test_gagal_menghapus_transaksi_jika_periode_bulan_sudah_dikunci(): void
    {
        $bendahara = $this->buatBendahara();
        $transaksi = TransaksiKeuangan::factory()->create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'tanggal'      => '2026-05-10',
            'donasi_id'    => null,
            'dicatat_oleh' => $bendahara->id,
        ]);

        LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 5,
            'status' => 'disetujui',
        ]);

        $response = $this->actingAs($bendahara)
            ->from(route('bendahara.keuangan.index'))
            ->delete(route('bendahara.keuangan.destroy', $transaksi->id));

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('transaksi_keuangans', ['id' => $transaksi->id]);
    }

    public function test_mengembalikan_404_jika_id_keuangan_tidak_ditemukan(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->delete(route('bendahara.keuangan.destroy', 99999));

        $response->assertNotFound();
    }
}
