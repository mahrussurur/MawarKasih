<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonasiDestroyTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_berhasil_menghapus_donasi_dan_transaksi_pemasukan_terkait(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create([
            'kode_donasi'    => 'DON-DEL01',
            'bukti_transfer' => null,
        ]);

        TransaksiKeuangan::factory()->create([
            'donasi_id'    => $donasi->id,
            'jenis'        => 'pemasukan',
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->delete(route('bendahara.donasi.destroy', $donasi->id));

        $response->assertRedirect(route('bendahara.donasi.index'));
        $response->assertSessionHas('success', 'Donasi DON-DEL01 berhasil dihapus.');

        $this->assertDatabaseMissing('donasi', ['id' => $donasi->id]);
        $this->assertDatabaseMissing('transaksi_keuangans', ['donasi_id' => $donasi->id]);
    }

    public function test_bendahara_berhasil_menghapus_donasi_beserta_file_bukti_transfer(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create([
            'kode_donasi'    => 'DON-DEL02',
            'bukti_transfer' => 'original/bukti_transfer/hapus.jpg',
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

        $response = $this->actingAs($bendahara)->delete(route('bendahara.donasi.destroy', $donasi->id));

        $response->assertRedirect(route('bendahara.donasi.index'));
        $this->assertSame(['original/bukti_transfer/hapus.jpg'], $deletedPaths);
        $this->assertDatabaseMissing('donasi', ['id' => $donasi->id]);
    }

    public function test_mengembalikan_404_jika_id_donasi_tidak_ditemukan(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->delete(route('bendahara.donasi.destroy', 99999));

        $response->assertNotFound();
    }
}
