<?php
// MAHRUS
namespace Tests\Feature\Bendahara;

use App\Models\Donasi;
use App\Models\TransaksiKeuangan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KeuanganEditTest extends TestCase
{
    use RefreshDatabase;

    private function buatBendahara(): User
    {
        return User::factory()->create(['role' => 'bendahara', 'status' => 'aktif']);
    }

    public function test_bendahara_dapat_melihat_halaman_edit_transaksi_keuangan_manual(): void
    {
        $bendahara = $this->buatBendahara();
        $transaksi = TransaksiKeuangan::factory()->create([
            'jenis'        => 'pengeluaran',
            'kategori'     => 'OPERASIONAL',
            'keterangan'   => 'Transaksi Manual Edit',
            'donasi_id'    => null,
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->get(route('bendahara.keuangan.edit', $transaksi->id));

        $response->assertOk();
        $response->assertViewIs('bendahara.keuangan.edit');
        $response->assertViewHas('keuangan');
        $response->assertSee('Transaksi Manual Edit');
    }

    public function test_bendahara_dialihkan_jika_mencoba_mengedit_transaksi_dari_donasi(): void
    {
        $bendahara = $this->buatBendahara();
        $donasi = Donasi::factory()->create();

        $transaksi = TransaksiKeuangan::factory()->create([
            'jenis'        => 'pemasukan',
            'kategori'     => 'DONASI',
            'donasi_id'    => $donasi->id,
            'dicatat_oleh' => $bendahara->id,
        ]);

        $response = $this->actingAs($bendahara)->get(route('bendahara.keuangan.edit', $transaksi->id));

        $response->assertRedirect(route('bendahara.keuangan.index'));
        $response->assertSessionHas('error');
    }

    public function test_mengembalikan_404_jika_id_keuangan_tidak_ditemukan(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->get(route('bendahara.keuangan.edit', 99999));

        $response->assertNotFound();
    }

    public function test_mengembalikan_404_jika_parameter_id_keuangan_bukan_angka(): void
    {
        $bendahara = $this->buatBendahara();

        $response = $this->actingAs($bendahara)->get('/bendahara/keuangan/abc/edit');

        $response->assertNotFound();
    }
}
