<?php

namespace Tests\Feature\Ketua;

use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\ArsipDokumen;
use App\Models\LaporanKeuanganBulanan;
use App\Models\ProfilPegawai;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    private function buatKetua(): User
    {
        $ketua = User::factory()->create([
            'role'   => 'ketua',
            'status' => 'aktif',
        ]);

        ProfilPegawai::create([
            'user_id' => $ketua->id,
            'nama'    => 'Ketua Yayasan',
            'jabatan' => 'Ketua',
        ]);

        return $ketua;
    }

    private function buatArsip(array $attributes = []): ArsipDokumen
    {
        return ArsipDokumen::create(array_merge([
            'judul'           => 'Dokumen Yayasan',
            'nomor_dokumen'   => 'DOC-' . fake()->unique()->numerify('###'),
            'kategori'        => 'Legalitas',
            'tanggal_dokumen' => '2026-01-10',
            'deskripsi'       => 'Deskripsi dokumen arsip',
            'file_name_asli'  => 'dokumen.pdf',
            'file_path'       => 'arsip/dokumen.pdf',
            'file_size'       => 1024,
            'mime_type'       => 'application/pdf',
            'uploaded_by'     => null,
        ], $attributes));
    }

    public function test_guest_dialihkan_ke_halaman_login(): void
    {
        $response = $this->get(route('ketua.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_pengguna_non_ketua_dilarang_mengakses_dashboard_ketua(): void
    {
        foreach (['admin', 'bendahara', 'donatur'] as $role) {
            $user = User::factory()->create(['role' => $role]);

            $response = $this->actingAs($user)->get(route('ketua.dashboard'));

            $response->assertForbidden();
        }
    }

    public function test_ketua_dapat_mengakses_halaman_dashboard_dengan_view_dan_variabel_yang_benar(): void
    {
        $ketua = $this->buatKetua();

        $response = $this->actingAs($ketua)->get(route('ketua.dashboard'));

        $response->assertOk();
        $response->assertViewIs('ketua.dashboard');
        $response->assertViewHasAll([
            'totalDonatur',
            'totalAnak',
            'totalAlumni',
            'totalArsip',
            'laporanMenungguReview',
            'laporanTerbaru',
            'arsipTerbaru',
        ]);
        $response->assertSee('Selamat Datang, Ketua Yayasan!');
    }

    public function test_dashboard_menampilkan_statistik_nol_dan_pesan_kosong_saat_database_kosong(): void
    {
        $ketua = $this->buatKetua();

        $response = $this->actingAs($ketua)->get(route('ketua.dashboard'));

        $response->assertOk();
        $response->assertViewHas('totalDonatur', 0);
        $response->assertViewHas('totalAnak', 0);
        $response->assertViewHas('totalAlumni', 0);
        $response->assertViewHas('totalArsip', 0);
        $response->assertViewHas('laporanMenungguReview', 0);

        $this->assertCount(0, $response->viewData('laporanTerbaru'));
        $this->assertCount(0, $response->viewData('arsipTerbaru'));

        $response->assertSee('Tidak ada laporan yang menunggu review saat ini.');
        $response->assertSee('Belum ada dokumen administrasi yang diarsipkan.');
    }

    public function test_dashboard_menghitung_agregasi_statistik_dan_laporan_menunggu_review_dengan_akurat(): void
    {
        $ketua = $this->buatKetua();

        // Donatur: 2 donatur, ditambah 1 admin & 1 bendahara (tidak boleh terhitung sebagai donatur)
        User::factory()->count(2)->create(['role' => 'donatur']);
        User::factory()->create(['role' => 'admin']);
        $bendahara = User::factory()->create(['role' => 'bendahara']);

        // Anak asuh: 3 aktif, 1 soft-deleted (tidak boleh terhitung)
        AnakAsuh::factory()->count(3)->create();
        $anakTerhapus = AnakAsuh::factory()->create();
        $anakTerhapus->delete();

        // Alumni: 2 data (anak_asuh terkait berstatus soft-deleted sebagaimana alur jadikan alumni)
        for ($i = 1; $i <= 2; $i++) {
            $anakAlumni = AnakAsuh::factory()->create();
            Alumni::factory()->create(['anak_asuh_id' => $anakAlumni->id]);
            $anakAlumni->delete();
        }

        // Arsip dokumen: 4 data
        for ($i = 1; $i <= 4; $i++) {
            $this->buatArsip(['judul' => "Arsip {$i}"]);
        }

        // Laporan bulanan: hanya 2 berstatus 'diajukan'
        LaporanKeuanganBulanan::factory()->create([
            'tahun'        => 2026,
            'bulan'        => 1,
            'status'       => 'diajukan',
            'submitted_by' => $bendahara->id,
            'submitted_at' => now(),
        ]);
        LaporanKeuanganBulanan::factory()->create([
            'tahun'        => 2026,
            'bulan'        => 2,
            'status'       => 'diajukan',
            'submitted_by' => $bendahara->id,
            'submitted_at' => now(),
        ]);
        LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 3,
            'status' => 'draft',
        ]);
        LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 4,
            'status' => 'disetujui',
        ]);
        LaporanKeuanganBulanan::factory()->create([
            'tahun'  => 2026,
            'bulan'  => 5,
            'status' => 'dikembalikan',
        ]);

        $response = $this->actingAs($ketua)->get(route('ketua.dashboard'));

        $response->assertOk();
        $response->assertViewHas('totalDonatur', 2);
        $response->assertViewHas('totalAnak', 3);
        $response->assertViewHas('totalAlumni', 2);
        $response->assertViewHas('totalArsip', 4);
        $response->assertViewHas('laporanMenungguReview', 2);
        $response->assertSee('2 Menunggu Tindakan');
    }

    public function test_laporan_terbaru_dibatasi_5_data_berstatus_diajukan_urut_periode_terbaru(): void
    {
        $ketua = $this->buatKetua();
        $bendahara = User::factory()->create(['role' => 'bendahara']);
        ProfilPegawai::create([
            'user_id' => $bendahara->id,
            'nama'    => 'Siti Bendahara',
            'jabatan' => 'Bendahara',
        ]);

        // Buat 7 laporan berstatus 'diajukan' pada periode berbeda
        $periodes = [
            [2025, 11],
            [2025, 12],
            [2026, 1],
            [2026, 2],
            [2026, 3],
            [2026, 4],
            [2026, 5],
        ];

        foreach ($periodes as [$tahun, $bulan]) {
            LaporanKeuanganBulanan::factory()->create([
                'tahun'        => $tahun,
                'bulan'        => $bulan,
                'status'       => 'diajukan',
                'submitted_by' => $bendahara->id,
                'submitted_at' => now(),
            ]);
        }

        // Buat 1 laporan berstatus 'disetujui' dengan periode lebih baru (tidak boleh masuk daftar)
        LaporanKeuanganBulanan::factory()->create([
            'tahun'        => 2026,
            'bulan'        => 6,
            'status'       => 'disetujui',
            'submitted_by' => $bendahara->id,
            'submitted_at' => now(),
        ]);

        $response = $this->actingAs($ketua)->get(route('ketua.dashboard'));

        $response->assertOk();
        $response->assertViewHas('laporanMenungguReview', 7);

        $laporanTerbaru = $response->viewData('laporanTerbaru');
        $this->assertCount(5, $laporanTerbaru);

        $urutanPeriode = $laporanTerbaru->map(fn ($item) => "{$item->tahun}-{$item->bulan}")->all();
        $this->assertSame([
            '2026-5',
            '2026-4',
            '2026-3',
            '2026-2',
            '2026-1',
        ], $urutanPeriode);
    }

    public function test_arsip_terbaru_dibatasi_5_dokumen_terbaru(): void
    {
        $ketua = $this->buatKetua();
        $admin = User::factory()->create(['role' => 'admin']);
        ProfilPegawai::create([
            'user_id' => $admin->id,
            'nama'    => 'Admin Arsip',
            'jabatan' => 'Administrator',
        ]);

        // Buat 7 dokumen dengan waktu pembuatan berurutan
        for ($i = 1; $i <= 7; $i++) {
            Carbon::setTestNow(Carbon::create(2026, 5, $i, 10, 0, 0));
            $this->buatArsip([
                'judul'       => "Dokumen Urut {$i}",
                'uploaded_by' => $admin->id,
            ]);
        }
        Carbon::setTestNow();

        $response = $this->actingAs($ketua)->get(route('ketua.dashboard'));

        $response->assertOk();
        $response->assertViewHas('totalArsip', 7);

        $arsipTerbaru = $response->viewData('arsipTerbaru');
        $this->assertCount(5, $arsipTerbaru);

        $judulUrut = $arsipTerbaru->pluck('judul')->all();
        $this->assertSame([
            'Dokumen Urut 7',
            'Dokumen Urut 6',
            'Dokumen Urut 5',
            'Dokumen Urut 4',
            'Dokumen Urut 3',
        ], $judulUrut);

        $response->assertSee('Dokumen Urut 7');
        $response->assertDontSee('Dokumen Urut 1');
        $response->assertDontSee('Dokumen Urut 2');
    }
}
