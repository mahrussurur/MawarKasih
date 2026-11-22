<?php

namespace Tests\Feature\Admin;

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AlumniAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public static function daftarEndpointAlumniProvider(): array
    {
        return [
            'halaman index alumni'  => ['GET', 'alumni.index', false],
            'halaman cetak alumni'  => ['GET', 'alumni.cetak', false],
            'halaman create alumni' => ['GET', 'alumni.create', 'anak_asuh'],
            'proses store alumni'   => ['POST', 'alumni.store', 'anak_asuh'],
            'halaman show alumni'   => ['GET', 'alumni.show', 'alumni'],
            'halaman edit alumni'   => ['GET', 'alumni.edit', 'alumni'],
            'proses update alumni'  => ['PUT', 'alumni.update', 'alumni'],
        ];
    }

    private function resolveUrl(string $routeName, string|bool $paramType): string
    {
        if ($paramType === 'anak_asuh') {
            $anakAsuh = AnakAsuh::factory()->create();
            return route($routeName, $anakAsuh->id);
        }

        if ($paramType === 'alumni') {
            $alumni = Alumni::factory()->create();
            return route($routeName, $alumni->id);
        }

        return route($routeName);
    }

    #[DataProvider('daftarEndpointAlumniProvider')]
    public function test_guest_dialihkan_ke_halaman_login(string $method, string $routeName, string|bool $paramType): void
    {
        $url = $this->resolveUrl($routeName, $paramType);

        $response = $this->call($method, $url);

        $response->assertRedirect(route('login'));
    }

    #[DataProvider('daftarEndpointAlumniProvider')]
    public function test_pengguna_non_admin_dilarang_mengakses_endpoint_alumni(string $method, string $routeName, string|bool $paramType): void
    {
        $donatur = User::factory()->create(['role' => 'donatur']);
        $url = $this->resolveUrl($routeName, $paramType);

        $response = $this->actingAs($donatur)->call($method, $url);

        $response->assertForbidden();
    }
}
