<?php



use App\Http\Controllers\Ketua\DashboardController;
use App\Models\Alumni;
use App\Models\AnakAsuh;
use App\Models\ArsipDokumen;
use App\Models\LaporanKeuanganBulanan;
use App\Models\ProfilPegawai;
use App\Models\User;
use Illuminate\View\View;

function createTestAnak(array $attributes = []): AnakAsuh
{
    return AnakAsuh::create(array_merge([
        'nama' => 'Anak Test ' . uniqid(),
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '2012-05-10',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
    ], $attributes));
}

function createTestAlumni(array $attributes = []): Alumni
{
    $anakAsuhId = $attributes['anak_asuh_id'] ?? createTestAnak()->id;

    return Alumni::create(array_merge([
        'anak_asuh_id' => $anakAsuhId,
        'nama' => 'Alumni Test ' . uniqid(),
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '2000-01-01',
        'jenis_kelamin' => 'L',
        'status_social_anak' => 'Yatim',
        'tanggal_keluar' => '2023-01-01',
    ], $attributes));
}

function createTestArsip(array $attributes = []): ArsipDokumen
{
    return ArsipDokumen::create(array_merge([
        'judul' => 'Dokumen Test ' . uniqid(),
        'kategori' => 'Legalitas',
        'file_name_asli' => 'doc.pdf',
        'file_path' => 'arsip/doc.pdf',
        'file_size' => 2048,
        'mime_type' => 'application/pdf',
    ], $attributes));
}

function createTestLaporan(array $attributes = []): LaporanKeuanganBulanan
{
    static $counter = 1;
    $counter++;

    return LaporanKeuanganBulanan::create(array_merge([
        'tahun' => 2026,
        'bulan' => ($counter % 12) + 1,
        'saldo_awal' => 0,
        'total_pemasukan' => 1000000,
        'total_pengeluaran' => 500000,
        'saldo_akhir' => 500000,
        'status' => 'diajukan',
    ], $attributes));
}

test('index returns ketua.dashboard view instance', function () {
    $controller = new DashboardController();

    $response = $controller->index();

    expect($response)->toBeInstanceOf(View::class);
    expect($response->name())->toBe('ketua.dashboard');
});

test('index calculates total donatur accurately by counting only users with role donatur', function () {
    User::factory()->create(['role' => 'donatur']);
    User::factory()->create(['role' => 'donatur']);
    User::factory()->create(['role' => 'admin']);
    User::factory()->create(['role' => 'ketua']);
    User::factory()->create(['role' => 'bendahara']);

    $controller = new DashboardController();
    $view = $controller->index();

    expect($view->getData()['totalDonatur'])->toBe(2);
});

test('index calculates total anak asuh excluding soft deleted records', function () {
    $anak1 = createTestAnak();
    $anak2 = createTestAnak();
    $anakDeleted = createTestAnak();
    $anakDeleted->delete(); // Soft delete

    $controller = new DashboardController();
    $view = $controller->index();

    expect($view->getData()['totalAnak'])->toBe(2);
});

test('index calculates total alumni accurately', function () {
    createTestAlumni();
    createTestAlumni();
    createTestAlumni();

    $controller = new DashboardController();
    $view = $controller->index();

    expect($view->getData()['totalAlumni'])->toBe(3);
});

test('index calculates total arsip dokumen accurately', function () {
    createTestArsip();
    createTestArsip();

    $controller = new DashboardController();
    $view = $controller->index();

    expect($view->getData()['totalArsip'])->toBe(2);
});

test('index calculates laporan menunggu review by counting only status diajukan', function () {
    createTestLaporan(['tahun' => 2026, 'bulan' => 1, 'status' => 'diajukan']);
    createTestLaporan(['tahun' => 2026, 'bulan' => 2, 'status' => 'diajukan']);
    createTestLaporan(['tahun' => 2026, 'bulan' => 3, 'status' => 'draft']);
    createTestLaporan(['tahun' => 2026, 'bulan' => 4, 'status' => 'disetujui']);
    createTestLaporan(['tahun' => 2026, 'bulan' => 5, 'status' => 'dikembalikan']);

    $controller = new DashboardController();
    $view = $controller->index();

    expect($view->getData()['laporanMenungguReview'])->toBe(2);
});

test('index retrieves at most 5 laporan terbaru with status diajukan ordered by tahun desc and bulan desc', function () {
    $bendahara = User::factory()->create(['role' => 'bendahara']);
    ProfilPegawai::create([
        'user_id' => $bendahara->id,
        'nama' => 'Bendahara Panti',
    ]);

    // Create 7 laporan diajukan with different months/years
    $laporans = [
        createTestLaporan(['tahun' => 2025, 'bulan' => 10, 'status' => 'diajukan', 'submitted_by' => $bendahara->id]),
        createTestLaporan(['tahun' => 2025, 'bulan' => 12, 'status' => 'diajukan', 'submitted_by' => $bendahara->id]),
        createTestLaporan(['tahun' => 2026, 'bulan' => 1, 'status' => 'diajukan', 'submitted_by' => $bendahara->id]),
        createTestLaporan(['tahun' => 2026, 'bulan' => 2, 'status' => 'diajukan', 'submitted_by' => $bendahara->id]),
        createTestLaporan(['tahun' => 2026, 'bulan' => 3, 'status' => 'diajukan', 'submitted_by' => $bendahara->id]),
        createTestLaporan(['tahun' => 2026, 'bulan' => 4, 'status' => 'diajukan', 'submitted_by' => $bendahara->id]),
        createTestLaporan(['tahun' => 2026, 'bulan' => 5, 'status' => 'draft', 'submitted_by' => $bendahara->id]), // Should be ignored
    ];

    $controller = new DashboardController();
    $view = $controller->index();
    $laporanTerbaru = $view->getData()['laporanTerbaru'];

    // Harus take(5)
    expect($laporanTerbaru)->toHaveCount(5);

    // Draft tidak boleh masuk
    expect($laporanTerbaru->pluck('status')->unique()->all())->toBe(['diajukan']);

    // Harus berurutan tahun DESC, bulan DESC: (2026, 4), (2026, 3), (2026, 2), (2026, 1), (2025, 12)
    $expectedOrder = [
        ['tahun' => 2026, 'bulan' => 4],
        ['tahun' => 2026, 'bulan' => 3],
        ['tahun' => 2026, 'bulan' => 2],
        ['tahun' => 2026, 'bulan' => 1],
        ['tahun' => 2025, 'bulan' => 12],
    ];

    foreach ($expectedOrder as $index => $expected) {
        expect($laporanTerbaru[$index]->tahun)->toBe($expected['tahun']);
        expect($laporanTerbaru[$index]->bulan)->toBe($expected['bulan']);
    }

    // Eager loading check: relation submitter.profilPegawai should be loaded
    expect($laporanTerbaru->first()->relationLoaded('submitter'))->toBeTrue();
    expect($laporanTerbaru->first()->submitter->relationLoaded('profilPegawai'))->toBeTrue();
    expect($laporanTerbaru->first()->submitter->profilPegawai->nama)->toBe('Bendahara Panti');
});

test('index retrieves at most 5 arsip terbaru ordered by latest created_at with uploader relation eager loaded', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    ProfilPegawai::create([
        'user_id' => $admin->id,
        'nama' => 'Admin Panti',
    ]);

    // Create 6 arsip records at different timestamps using time travel
    for ($i = 1; $i <= 6; $i++) {
        $this->travel(1)->minutes();
        createTestArsip([
            'judul' => "Dokumen {$i}",
            'uploaded_by' => $admin->id,
        ]);
    }

    $controller = new DashboardController();
    $view = $controller->index();
    $arsipTerbaru = $view->getData()['arsipTerbaru'];

    // Harus take(5)
    expect($arsipTerbaru)->toHaveCount(5);

    // Dokumen paling baru (Dokumen 6) harus paling awal
    expect($arsipTerbaru->first()->judul)->toBe('Dokumen 6');
    expect($arsipTerbaru->last()->judul)->toBe('Dokumen 2');

    // Eager loading check: uploader.profilPegawai should be loaded
    expect($arsipTerbaru->first()->relationLoaded('uploader'))->toBeTrue();
    expect($arsipTerbaru->first()->uploader->relationLoaded('profilPegawai'))->toBeTrue();
    expect($arsipTerbaru->first()->uploader->profilPegawai->nama)->toBe('Admin Panti');
});

test('index handles empty database gracefully with zeroes and empty collections', function () {
    $controller = new DashboardController();
    $view = $controller->index();
    $data = $view->getData();

    expect($data['totalDonatur'])->toBe(0);
    expect($data['totalAnak'])->toBe(0);
    expect($data['totalAlumni'])->toBe(0);
    expect($data['totalArsip'])->toBe(0);
    expect($data['laporanMenungguReview'])->toBe(0);
    expect($data['laporanTerbaru'])->toBeEmpty();
    expect($data['arsipTerbaru'])->toBeEmpty();
});
