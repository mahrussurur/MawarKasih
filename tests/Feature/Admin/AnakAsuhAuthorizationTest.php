<?php
// RIDHO
namespace Tests\Feature\Admin;

use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AnakAsuhAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public static function daftarEndpointAnakAsuhProvider(): array
    {
        return [
            'halaman index anak asuh'  => ['GET', 'anak-asuh.index', false],
            'halaman cetak anak asuh'  => ['GET', 'anak-asuh.cetak', false],
            'halaman create anak asuh' => ['GET', 'anak-asuh.create', false],
            'proses store anak asuh'   => ['POST', 'anak-asuh.store', false],
            'halaman show anak asuh'   => ['GET', 'anak-asuh.show', true],
            'halaman edit anak asuh'   => ['GET', 'anak-asuh.edit', true],
            'proses update anak asuh'  => ['PUT', 'anak-asuh.update', true],
        ];
    }

    private function resolveUrl(string $routeName, bool $hasParam): string
    {
        if ($hasParam) {
            $anakAsuh = AnakAsuh::factory()->create();
            return route($routeName, $anakAsuh->id);
        }

        return route($routeName);
    }

    #[DataProvider('daftarEndpointAnakAsuhProvider')]
    public function test_guest_dialihkan_ke_halaman_login(string $method, string $routeName, bool $hasParam): void
    {
        $url = $this->resolveUrl($routeName, $hasParam);

        $response = $this->call($method, $url);

        $response->assertRedirect(route('login'));
    }

    #[DataProvider('daftarEndpointAnakAsuhProvider')]
    public function test_pengguna_non_admin_dilarang_mengakses_endpoint_anak_asuh(string $method, string $routeName, bool $hasParam): void
    {
        $donatur = User::factory()->create(['role' => 'donatur']);
        $url = $this->resolveUrl($routeName, $hasParam);

        $response = $this->actingAs($donatur)->call($method, $url);

        $response->assertForbidden();
    }
}
