<?php

namespace Tests\Feature\Ketua;

use App\Models\ArsipDokumen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArsipDokumenControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create([
            'role' => 'ketua',
        ]));
    }

    // Membuat data arsip dokumen untuk pengujian
    protected function buatArsipDokumen()
    {
        return ArsipDokumen::create([
            'judul' => 'Dokumen Legalitas Yayasan',
            'nomor_dokumen' => 'DOC-001',
            'kategori' => 'Legalitas',
            'tanggal_dokumen' => '2026-01-10',
            'deskripsi' => 'Dokumen legalitas Yayasan Mawar Kasih',
            'file_name_asli' => 'dokumen.pdf',
            'file_path' => 'arsip/dokumen.pdf',
            'file_size' => 1024,
            'mime_type' => 'application/pdf',
            'uploaded_by' => null,
        ]);
    }

    // Menguji Ketua berhasil melihat daftar arsip dokumen
    public function test_ketua_berhasil_melihat_daftar_arsip_dokumen(): void
    {
        $this->buatArsipDokumen();

        $response = $this->get(route('ketua.arsip-dokumen.index'));

        $response->assertOk();
        $response->assertViewIs('ketua.arsip-dokumen.index');
        $response->assertViewHas('arsips');
        $response->assertViewHas('totalArsip');
        $response->assertViewHas('kategoriList');
    }

    // Menguji Ketua berhasil melihat detail arsip dokumen
    public function test_ketua_berhasil_melihat_detail_arsip_dokumen(): void
    {
        $arsip = $this->buatArsipDokumen();

        $response = $this->get(
            route('ketua.arsip-dokumen.show', $arsip->id)
        );

        $response->assertOk();
        $response->assertViewIs('ketua.arsip-dokumen.show');
        $response->assertViewHas('arsip');
    }

    // Menguji Ketua berhasil mengunduh arsip dokumen
    public function test_ketua_berhasil_mengunduh_arsip_dokumen(): void
    {
        Storage::fake('local');

        $arsip = $this->buatArsipDokumen();

        Storage::disk('local')->put(
            'arsip/dokumen.pdf',
            'Isi dokumen pengujian'
        );

        $response = $this->get(
            route('ketua.arsip-dokumen.download', $arsip->id)
        );

        $response->assertOk();
        $response->assertDownload('dokumen.pdf');
    }
}
