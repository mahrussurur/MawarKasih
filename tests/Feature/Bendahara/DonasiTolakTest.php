<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonasiTolakTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_berhasil_menolak_donasi_pending_dengan_catatan_admin(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create([
            'kode_donasi' => 'DON-TOL01',
            'status'      => 'pending',
        ]);

        $response = $this->actingAs($bendahara)
            ->from(route('bendahara.donasi.index'))
            ->patch(route('bendahara.donasi.tolak', $donasi->id), [
                'catatan_admin' => 'Bukti transfer tidak terbaca.',
            ]);

        $response->assertRedirect(route('bendahara.donasi.index'));
        $response->assertSessionHas('success', 'Donasi DON-TOL01 telah ditolak.');

        $this->assertDatabaseHas('donasi', [
            'id'            => $donasi->id,
            'status'        => 'ditolak',
            'catatan_admin' => 'Bukti transfer tidak terbaca.',
        ]);
        $this->assertDatabaseMissing('transaksi_keuangans', ['donasi_id' => $donasi->id]);
    }

    public function test_tolak_tanpa_catatan_menggunakan_catatan_default(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($bendahara)->patch(route('bendahara.donasi.tolak', $donasi->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('donasi', [
            'id'            => $donasi->id,
            'status'        => 'ditolak',
            'catatan_admin' => 'Bukti transfer tidak valid.',
        ]);
    }

    public function test_gagal_menolak_jika_status_donasi_bukan_pending(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create(['status' => 'diterima']);

        $response = $this->actingAs($bendahara)->patch(route('bendahara.donasi.tolak', $donasi->id));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Hanya donasi berstatus pending yang bisa ditolak.');
    }

    public function test_gagal_menolak_jika_catatan_admin_melebihi_500_karakter(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($bendahara)->patch(route('bendahara.donasi.tolak', $donasi->id), [
            'catatan_admin' => str_repeat('a', 501),
        ]);

        $response->assertSessionHasErrors('catatan_admin');
        $this->assertEquals('pending', $donasi->fresh()->status);
    }
}
