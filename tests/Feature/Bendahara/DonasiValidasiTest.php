<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonasiValidasiTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_berhasil_memvalidasi_donasi_pending_dan_mencatat_pemasukan(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create([
            'kode_donasi' => 'DON-VAL01',
            'nominal'     => 600000,
            'status'      => 'pending',
        ]);

        $response = $this->actingAs($bendahara)
            ->from(route('bendahara.donasi.index'))
            ->patch(route('bendahara.donasi.validasi', $donasi->id), [
                'catatan_admin' => 'Mutasi rekening sudah terverifikasi.',
            ]);

        $response->assertRedirect(route('bendahara.donasi.index'));
        $response->assertSessionHas('success', 'Donasi DON-VAL01 berhasil divalidasi dan dicatat sebagai pemasukan.');

        $this->assertDatabaseHas('donasi', [
            'id'            => $donasi->id,
            'status'        => 'diterima',
            'catatan_admin' => 'Mutasi rekening sudah terverifikasi.',
        ]);

        $this->assertDatabaseHas('transaksi_keuangans', [
            'donasi_id' => $donasi->id,
            'jenis'     => 'pemasukan',
            'nominal'   => 600000,
        ]);
    }

    public function test_validasi_tanpa_catatan_menggunakan_catatan_default(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($bendahara)->patch(route('bendahara.donasi.validasi', $donasi->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('donasi', [
            'id'            => $donasi->id,
            'status'        => 'diterima',
            'catatan_admin' => 'Donasi telah diterima. Terima kasih.',
        ]);
    }

    public function test_gagal_memvalidasi_jika_status_donasi_bukan_pending(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create(['status' => 'diterima']);

        $response = $this->actingAs($bendahara)->patch(route('bendahara.donasi.validasi', $donasi->id));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Hanya donasi berstatus pending yang bisa divalidasi.');
    }

    public function test_gagal_memvalidasi_jika_catatan_admin_melebihi_500_karakter(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($bendahara)->patch(route('bendahara.donasi.validasi', $donasi->id), [
            'catatan_admin' => str_repeat('a', 501),
        ]);

        $response->assertSessionHasErrors('catatan_admin');
        $this->assertEquals('pending', $donasi->fresh()->status);
    }
}
