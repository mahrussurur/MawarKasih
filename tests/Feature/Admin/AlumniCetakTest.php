<?php
// RIDHO
namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AlumniCetakTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dapat_mencetak_laporan_data_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Alumni::factory()->create(['nama' => 'Ahmad Dahlan']);

        $response = $this->actingAs($admin)->get(route('alumni.cetak'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $this->assertStringContainsString('Laporan_Data_Alumni_Mawar_Kasih.pdf', (string) $response->headers->get('Content-Disposition'));
    }

    public function test_admin_tidak_dapat_mencetak_jika_belum_ada_data_alumni(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->from(route('alumni.index'))
            ->actingAs($admin)
            ->get(route('alumni.cetak'));

        $response->assertRedirect(route('alumni.index'));
        $response->assertSessionHas('error');
    }
}
