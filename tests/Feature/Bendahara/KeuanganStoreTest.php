<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\LaporanKeuanganBulanan;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class KeuanganStoreTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_berhasil_menyimpan_transaksi_keuangan_tanpa_bukti(): void
    {
        $bendahara = $this->buatBendahara();

        $payload = TransaksiKeuangan::factory()->make([
            'jenis'      => 'pengeluaran',
            'kategori'   => 'OPERASIONAL',
            'nominal'    => 250000,
            'keterangan' => 'Pembelian ATK Panti',
            'tanggal'    => '2026-05-10',
        ])->toArray();

        $response = $this->actingAs($bendahara)->post(route('bendahara.keuangan.store'), $payload);

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $response->assertSessionHas('success', 'Data Keuangan berhasil ditambahkan.');

        $this->assertDatabaseHas('transaksi_keuangans', [
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'nominal'      => 250000,
            'keterangan'   => 'Pembelian ATK Panti',
            'dicatat_oleh' => $bendahara->id,
        ]);
    }

    public function test_bendahara_berhasil_menyimpan_transaksi_keuangan_dengan_bukti_transaksi(): void
    {
        $bendahara = $this->buatBendahara();

        $fakeImageService = new class extends ImageService {
            public function __construct() {}
            public function uploadAndGenerateWebp(UploadedFile $file, string $folder): string
            {
                return 'original/' . $folder . '/nota_baru.webp';
            }
        };
        $this->app->instance(ImageService::class, $fakeImageService);

        $payload = array_merge(TransaksiKeuangan::factory()->make([
            'jenis'      => 'pengeluaran',
            'kategori'   => 'KONSUMSI',
            'nominal'    => 350000,
            'keterangan' => 'Belanja Sembako',
            'tanggal'    => '2026-05-12',
        ])->toArray(), [
            'bukti_transaksi' => UploadedFile::fake()->image('nota.jpg', 400, 400),
        ]);

        $response = $this->actingAs($bendahara)->post(route('bendahara.keuangan.store'), $payload);

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $this->assertDatabaseHas('transaksi_keuangans', [
            'keterangan'      => 'Belanja Sembako',
            'bukti_transaksi' => 'original/bukti_transaksi/nota_baru.webp',
        ]);
    }

    public function test_gagal_menyimpan_transaksi_jika_periode_bulan_sudah_dikunci(): void
    {
        $bendahara = $this->buatBendahara();

        LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 5,
            'status' => 'disetujui',
        ]);

        $payload = TransaksiKeuangan::factory()->make([
            'jenis'      => 'pengeluaran',
            'kategori'   => 'OPERASIONAL',
            'nominal'    => 100000,
            'keterangan' => 'Transaksi Bulan Terkunci',
            'tanggal'    => '2026-05-20',
        ])->toArray();

        $response = $this->actingAs($bendahara)
            ->from(route('bendahara.keuangan.create'))
            ->post(route('bendahara.keuangan.store'), $payload);

        $response->assertRedirect(route('bendahara.keuangan.create'));
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('transaksi_keuangans', 0);
    }

    public function test_gagal_menyimpan_transaksi_jika_validasi_tidak_terpenuhi(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->post(route('bendahara.keuangan.store'), [
            'jenis'           => 'tidak-valid',
            'kategori'        => 'TIDAK_ADA',
            'nominal'         => 0,
            'keterangan'      => '',
            'tanggal'         => 'bukan-tanggal',
            'bukti_transaksi' => UploadedFile::fake()->create('file.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors([
            'jenis',
            'kategori',
            'nominal',
            'keterangan',
            'tanggal',
            'bukti_transaksi',
        ]);
        $this->assertDatabaseCount('transaksi_keuangans', 0);
    }
}
