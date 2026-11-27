<?php
// RIDHO
namespace Tests\Feature\Admin;

use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnakAsuhCetakTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_mencetak_laporan_data_anak_asuh(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        AnakAsuh::factory()->create(['nama' => 'Ahmad Dahlan']);

        $response = $this->actingAs($admin)->get(route('anak-asuh.cetak'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString('Laporan_Data_Anak_Asuh_Mawar_Kasih.pdf', (string) $response->headers->get('Content-Disposition'));
    }

    public function test_admin_tidak_dapat_mencetak_jika_belum_ada_data_anak_asuh(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->from(route('anak-asuh.index'))
            ->actingAs($admin)
            ->get(route('anak-asuh.cetak'));

        $response->assertRedirect(route('anak-asuh.index'));
        $response->assertSessionHas('error');
    }
}
