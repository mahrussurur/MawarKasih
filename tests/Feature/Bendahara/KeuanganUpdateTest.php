<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class KeuanganUpdateTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_berhasil_memperbarui_transaksi_keuangan_dan_mengganti_bukti(): void
    {
        $bendahara = $this->buatBendahara();
        $transaksi = TransaksiKeuangan::factory()->create([
            'jenis'           => 'pengeluaran',
            'kategori'        => 'OPERASIONAL',
            'nominal'         => 150000,
            'keterangan'      => 'Keterangan Lama',
            'tanggal'         => '2026-05-10',
            'bukti_transaksi' => 'original/bukti_transaksi/lama.jpg',
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
            public function uploadAndGenerateWebp(UploadedFile $file, string $folder): string
            {
                return 'original/' . $folder . '/baru.webp';
            }
        };
        $this->app->instance(ImageService::class, $fakeImageService);

        $updateData = [
            'jenis'           => 'pengeluaran',
            'kategori'        => 'KONSUMSI',
            'nominal'         => 300000,
            'keterangan'      => 'Keterangan Diperbarui',
            'tanggal'         => '2026-05-12',
            'bukti_transaksi' => UploadedFile::fake()->image('baru.jpg', 400, 400),
        ];

        $response = $this->actingAs($bendahara)->put(route('bendahara.keuangan.update', $transaksi->id), $updateData);

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $response->assertSessionHas('success', 'Data Keuangan berhasil diperbarui.');
        $this->assertSame(['original/bukti_transaksi/lama.jpg'], $deletedPaths);

        $this->assertDatabaseHas('transaksi_keuangans', [
            'id'              => $transaksi->id,
            'kategori'        => 'KONSUMSI',
            'nominal'         => 300000,
            'keterangan'      => 'Keterangan Diperbarui',
            'bukti_transaksi' => 'original/bukti_transaksi/baru.webp',
        ]);
    }

    public function test_gagal_memperbarui_transaksi_jika_berasal_dari_donasi(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create();

        $transaksi = TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'nominal'      => 500000,
            'donasi_id'    => $donasi->id,
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->put(route('bendahara.keuangan.update', $transaksi->id), [
            'jenis'      => 'pemasukan',
            'kategori'   => 'LAINNYA',
            'nominal'    => 999999,
            'keterangan' => 'Coba Ubah Donasi',
            'tanggal'    => '2026-05-15',
        ]);

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $response->assertSessionHas('error');
        $this->assertEquals(500000, $transaksi->fresh()->nominal);
    }

    public function test_gagal_memperbarui_transaksi_jika_periode_bulan_sudah_dikunci(): void
    {
        $bendahara = $this->buatBendahara();
        $transaksi = TransaksiKeuangan::factory()->create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'nominal'      => 200000,
            'keterangan'   => 'Sebelum Dikunci',
            'tanggal'      => '2026-05-10',
            'donasi_id'    => null,
            'dicatat_oleh' => $bendahara->id,
        ]);

        LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 5,
            'status' => 'diajukan',
        ]);

        $response = $this->actingAs($bendahara)
            ->from(route('bendahara.keuangan.edit', $transaksi->id))
            ->put(route('bendahara.keuangan.update', $transaksi->id), [
                'jenis'      => 'pengeluaran',
                'kategori'   => 'OPERASIONAL',
                'nominal'    => 500000,
                'keterangan' => 'Ubah Saat Terkunci',
                'tanggal'    => '2026-05-11',
            ]);

        $response->assertRedirect(route('bendahara.keuangan.edit', $transaksi->id));
        $response->assertSessionHas('error');
        $this->assertEquals('Sebelum Dikunci', $transaksi->fresh()->keterangan);
    }

    public function test_gagal_memperbarui_jika_validasi_tidak_terpenuhi_atau_id_tidak_ditemukan(): void
    {
        $bendahara = $this->buatBendahara();
        $transaksi = TransaksiKeuangan::factory()->create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'donasi_id'    => null,
            'dicatat_oleh' => $bendahara->id,
        ]);

        $responseInvalid = $this->actingAs($bendahara)->put(route('bendahara.keuangan.update', $transaksi->id), [
            'jenis'      => 'salah',
            'kategori'   => '',
            'nominal'    => -10,
            'keterangan' => '',
            'tanggal'    => 'bukan-tanggal',
        ]);
        $responseInvalid->assertSessionHasErrors(['jenis', 'kategori', 'nominal', 'keterangan', 'tanggal']);

        $responseNotFound = $this->actingAs($bendahara)->put(route('bendahara.keuangan.update', 99999), [
            'jenis'      => 'pengeluaran',
            'kategori'   => 'OPERASIONAL',
            'nominal'    => 100000,
            'keterangan' => 'Test',
            'tanggal'    => '2026-05-10',
        ]);
        $responseNotFound->assertNotFound();
    }
}
