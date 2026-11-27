<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DonasiStoreTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_berhasil_menyimpan_donasi_baru_dan_mencatat_pemasukan_keuangan(): void
    {
        $bendahara = $this->buatBendahara();

        $payload = Donasi::factory()->make([
            'nama_donatur'      => 'Hamba Allah',
            'no_hp'             => '081234567890',
            'nominal'           => 500000,
            'metode_pembayaran' => 'tunai',
            'keterangan'        => 'Donasi langsung di panti',
        ])->toArray();

        $response = $this->actingAs($bendahara)->post(route('bendahara.donasi.store'), $payload);

        $response->assertRedirect(route('bendahara.donasi.index'));
        $response->assertSessionHas('success', 'Donasi berhasil ditambahkan.');

        $this->assertDatabaseHas('donasi', [
            'nama_donatur' => 'Hamba Allah',
            'nominal'      => 500000,
            'status'       => 'diterima',
        ]);

        $donasi = Donasi::where('nama_donatur', 'Hamba Allah')->first();
        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'jenis'     => 'pemasukan',
            'nominal'   => 500000,
        ]);
    }

    public function test_bendahara_berhasil_menyimpan_donasi_dengan_bukti_transfer(): void
    {
        $bendahara = $this->buatBendahara();

        $fakeImageService = new class extends ImageService {
            public function __construct() {}
            public function uploadAndGenerateWebp(UploadedFile $file, string $folder): string
            {
                return 'original/' . $folder . '/bukti_baru.webp';
            }
        };
        $this->app->instance(ImageService::class, $fakeImageService);

        $payload = array_merge(Donasi::factory()->make([
            'nama_donatur' => 'Donatur Bukti',
            'no_hp'        => '081234567890',
            'nominal'      => 300000,
        ])->toArray(), [
            'bukti_transfer' => UploadedFile::fake()->image('bukti.jpg', 400, 400),
        ]);

        $response = $this->actingAs($bendahara)->post(route('bendahara.donasi.store'), $payload);

        $response->assertRedirect(route('bendahara.donasi.index'));
        $this->assertDatabaseHas('donasi', [
            'nama_donatur'   => 'Donatur Bukti',
            'bukti_transfer' => 'original/bukti_transfer/bukti_baru.webp',
        ]);
    }

    public function test_gagal_menyimpan_donasi_jika_field_wajib_kosong_atau_nominal_kurang_dari_1000(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->post(route('bendahara.donasi.store'), [
            'nama_donatur'      => '',
            'nominal'           => 500,
            'metode_pembayaran' => '',
        ]);

        $response->assertSessionHasErrors(['nama_donatur', 'nominal', 'metode_pembayaran']);
        $this->assertDatabaseCount('donasi', 0);
    }

    public function test_gagal_menyimpan_donasi_jika_format_no_hp_atau_bukti_transfer_tidak_valid(): void
    {
        $bendahara = $this->buatBendahara();

        $payload = array_merge(Donasi::factory()->make([
            'no_hp'   => '123',
            'nominal' => 50000,
        ])->toArray(), [
            'bukti_transfer' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
        ]);

        $response = $this->actingAs($bendahara)->post(route('bendahara.donasi.store'), $payload);

        $response->assertSessionHasErrors(['no_hp', 'bukti_transfer']);
        $this->assertDatabaseCount('donasi', 0);
    }
}
