<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DonasiUpdateTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_berhasil_memperbarui_data_donasi_dan_sinkronisasi_pemasukan(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create([
            'nama_donatur' => 'Nama Lama',
            'nominal'      => 100000,
            'status'       => 'diterima',
        ]);

        TransaksiKeuangan::factory()->create([
            'donasi_id'    => $donasi->id,
            'jenis'        => 'pemasukan',
            'nominal'      => 100000,
            'dicatat_oleh' => $bendahara->id,
        ]);

        $updateData = Donasi::factory()->make([
            'nama_donatur'      => 'Nama Baru',
            'nominal'           => 750000,
            'metode_pembayaran' => 'transfer_bca',
            'tanggal'           => '2026-05-15',
            'keterangan'        => 'Nominal diperbarui',
        ])->toArray();

        $response = $this->actingAs($bendahara)->put(route('bendahara.donasi.update', $donasi->id), $updateData);

        $response->assertRedirect(route('bendahara.donasi.index'));
        $response->assertSessionHas('success', 'Data donasi berhasil diperbarui.');

        $this->assertDatabaseHas('donasi', [
            'id'           => $donasi->id,
            'nama_donatur' => 'Nama Baru',
            'nominal'      => 750000,
        ]);

        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'nominal'   => 750000,
        ]);
    }

    public function test_bendahara_berhasil_memperbarui_donasi_sekaligus_mengganti_bukti_transfer(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create([
            'bukti_transfer' => 'original/bukti_transfer/lama.jpg',
        ]);

        $fakeImageService = new class extends ImageService {
            public function __construct() {}
            public function deleteImage(?string $originalPath): void {}
            public function uploadAndGenerateWebp(UploadedFile $file, string $folder): string
            {
                return 'original/' . $folder . '/baru.webp';
            }
        };
        $this->app->instance(ImageService::class, $fakeImageService);

        $updateData = array_merge(Donasi::factory()->make([
            'nominal' => 250000,
        ])->toArray(), [
            'bukti_transfer' => UploadedFile::fake()->image('baru.jpg', 400, 400),
        ]);

        $response = $this->actingAs($bendahara)->put(route('bendahara.donasi.update', $donasi->id), $updateData);

        $response->assertRedirect(route('bendahara.donasi.index'));
        $this->assertDatabaseHas('donasi', [
            'id'             => $donasi->id,
            'bukti_transfer' => 'original/bukti_transfer/baru.webp',
        ]);
    }

    public function test_gagal_memperbarui_donasi_jika_validasi_tidak_terpenuhi(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create(['nama_donatur' => 'Nama Tetap']);

        $response = $this->actingAs($bendahara)->put(route('bendahara.donasi.update', $donasi->id), [
            'nama_donatur'      => '',
            'nominal'           => 500,
            'metode_pembayaran' => '',
            'tanggal'           => 'bukan-tanggal',
        ]);

        $response->assertSessionHasErrors(['nama_donatur', 'nominal', 'metode_pembayaran', 'tanggal']);
        $this->assertEquals('Nama Tetap', $donasi->fresh()->nama_donatur);
    }

    public function test_mengembalikan_404_jika_id_donasi_tidak_ditemukan(): void
    {
        $bendahara = $this->buatBendahara();
        $updateData = Donasi::factory()->make()->toArray();

        $response = $this->actingAs($bendahara)->put(route('bendahara.donasi.update', 99999), $updateData);

        $response->assertNotFound();
    }
}
