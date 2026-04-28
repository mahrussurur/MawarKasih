@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* ── Welcome Banner ── */
    .welcome-banner { margin-bottom: 24px; }
    .welcome-banner h2 { font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 4px; }
    .welcome-banner p { font-size: 14px; color: #64748b; margin: 0; font-weight: 500; }

    /* ── Stat Cards Grid ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px)  { .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        display: flex; flex-direction: column; gap: 14px;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .stat-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,0.09); transform: translateY(-2px); }

    .stat-top { display: flex; align-items: center; gap: 14px; }
    .stat-icon {
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .stat-icon img { width: 34px; height: 34px; object-fit: contain; }
    .stat-icon-placeholder { font-size: 26px; }

    .stat-info .stat-label { font-size: 13px; font-weight: 600; color: #64748b; margin: 0 0 2px; }
    .stat-info .stat-value { font-size: 28px; font-weight: 800; color: #0f172a; margin: 0; line-height: 1; }

    .btn-lihat {
        display: block; width: 100%;
        padding: 10px 0; border-radius: 10px; border: none;
        font-size: 13px; font-weight: 700; color: #fff;
        cursor: pointer; text-align: center; text-decoration: none;
        transition: opacity 0.15s, transform 0.15s;
    }
    .btn-lihat:hover { opacity: 0.88; transform: translateY(-1px); }

    /* Warna per card */
    .card-blue  .stat-icon { background: #eff6ff; }
    .card-blue  .btn-lihat { background: #3b82f6; }
    .card-green .stat-icon { background: #f0fdf4; }
    .card-green .btn-lihat { background: #22c55e; }
    .card-amber .stat-icon { background: #fffbeb; }
    .card-amber .btn-lihat { background: #f59e0b; }
    .card-purple .stat-icon { background: #faf5ff; }
    .card-purple .btn-lihat { background: #a855f7; }

    /* ── Table Grid ── */
    .table-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 768px) { .table-grid { grid-template-columns: 1fr; } }

    .table-card {
        background: #fff; border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .table-card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 20px 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    .table-card-header h3 { font-size: 15px; font-weight: 800; color: #0f172a; margin: 0; }
    .table-card-header a { font-size: 13px; font-weight: 700; color: #3b82f6; text-decoration: none; }
    .table-card-header a:hover { color: #1d4ed8; }

    /* Table */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table thead tr { background: #f8fafc; }
    .data-table th {
        padding: 11px 16px; text-align: left;
        font-size: 11px; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.06em;
        border-bottom: 1px solid #f1f5f9;
    }
    .data-table td {
        padding: 13px 16px; font-size: 13px; font-weight: 500; color: #374151;
        border-bottom: 1px solid #f8fafc; vertical-align: middle;
    }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr:hover td { background: #fafbfc; }

    /* Badge status donasi */
    .badge {
        display: inline-flex; align-items: center;
        padding: 3px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 700; letter-spacing: 0.02em;
    }
    .badge-success { background: #dcfce7; color: #16a34a; }
    .badge-pending { background: #fef9c3; color: #a16207; }
    .badge-info    { background: #dbeafe; color: #1d4ed8; }
    .badge-warning { background: #ffedd5; color: #c2410c; }

    /* Nama donatur */
    .donor-name { font-weight: 700; color: #0f172a; }
    .donor-amount { font-weight: 700; color: #0f172a; }

    /* Empty state */
    .empty-state {
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; padding: 48px 20px; color: #cbd5e1;
    }
    .empty-state svg { width: 48px; height: 48px; margin-bottom: 12px; }
    .empty-state p { font-size: 13px; font-weight: 600; margin: 0; }

    /* Animasi stagger */
    .stat-card:nth-child(1) { animation: fadeInUp 0.35s ease 0.05s both; }
    .stat-card:nth-child(2) { animation: fadeInUp 0.35s ease 0.10s both; }
    .stat-card:nth-child(3) { animation: fadeInUp 0.35s ease 0.15s both; }
    .stat-card:nth-child(4) { animation: fadeInUp 0.35s ease 0.20s both; }
    .table-card:nth-child(1) { animation: fadeInUp 0.35s ease 0.25s both; }
    .table-card:nth-child(2) { animation: fadeInUp 0.35s ease 0.30s both; }

    @keyframes fadeInUp {
        from { opacity:0; transform:translateY(16px); }
        to   { opacity:1; transform:translateY(0); }
    }
</style>
@endpush

@section('content')

    {{-- ── Welcome ── --}}
    <div class="welcome-banner">
        <h2>Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
        <p>Ini adalah dashboard utama pengelolaan Yayasan Mawar Kasih.</p>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="stat-grid">

        {{-- Total Anak Asuh --}}
        <div class="stat-card card-blue">
            <div class="stat-top">
                <div class="stat-icon">
                    {{-- Ganti dengan emoji/icon/img sesuai kebutuhan --}}
                    <span class="stat-icon-placeholder">👧</span>
                </div>
                <div class="stat-info">
                    <p class="stat-label">Total Anak Asuh</p>
                    <p class="stat-value">{{ $totalAnak ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('anak-asuh.index') }}" class="btn-lihat">Lihat Data</a>
        </div>

        {{-- Total Pengasuh --}}
        <div class="stat-card card-green">
            <div class="stat-top">
                <div class="stat-icon">
                    <span class="stat-icon-placeholder">👨‍👩‍👧</span>
                </div>
                <div class="stat-info">
                    <p class="stat-label">Total Pengasuh</p>
                    <p class="stat-value">{{ $totalPengasuh ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('pengasuh.index') }}" class="btn-lihat">Lihat Data</a>
        </div>

        {{-- Total Kegiatan --}}
        <div class="stat-card card-amber">
            <div class="stat-top">
                <div class="stat-icon">
                    <span class="stat-icon-placeholder">📅</span>
                </div>
                <div class="stat-info">
                    <p class="stat-label">Total Kegiatan</p>
                    <p class="stat-value">{{ $totalKegiatan ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('kegiatan.index') }}" class="btn-lihat">Lihat Data</a>
        </div>

        {{-- Total Donatur --}}
        <div class="stat-card card-purple">
            <div class="stat-top">
                <div class="stat-icon">
                    <span class="stat-icon-placeholder">🤝</span>
                </div>
                <div class="stat-info">
                    <p class="stat-label">Total Donasi</p>
                    <p class="stat-value">{{ $totalDonatur ?? 0 }}</p>
                </div>
            </div>
            <a href="{{ route('donasi.index') }}" class="btn-lihat">Lihat Data</a>
        </div>

    </div>

    {{-- ── Tabel Terbaru ── --}}
    <div class="table-grid">

        {{-- Donasi Terbaru --}}
        <div class="table-card">
            <div class="table-card-header">
                <h3>Donasi Terbaru</h3>
                <a href="{{ route('donasi.index') }}">Lihat semua →</a>
            </div>

            @if(isset($donasiTerbaru) && $donasiTerbaru->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Donatur</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donasiTerbaru as $donasi)
                        <tr>
                            <td><span class="donor-name">{{ $donasi->nama_donatur }}</span></td>
                            <td><span class="donor-amount">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($donasi->tanggal)->format('d M Y') }}</td>
                            <td>
                                @if($donasi->status === 'diterima')
                                    <span class="badge badge-success">Diterima</span>
                                @elseif($donasi->status === 'pending')
                                    <span class="badge badge-pending">Pending</span>
                                @else
                                    <span class="badge badge-info">{{ $donasi->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                {{-- Empty State --}}
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <p>Belum ada data donasi terbaru</p>
                </div>
            @endif
        </div>

        {{-- Kegiatan Terbaru --}}
        <div class="table-card">
            <div class="table-card-header">
                <h3>Kegiatan Terbaru</h3>
                <a href="{{ route('kegiatan.index') }}">Lihat semua →</a>
            </div>

            @if(isset($kegiatanTerbaru) && $kegiatanTerbaru->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kegiatanTerbaru as $kegiatan)
                        <tr>
                            <td><span class="donor-name">{{ $kegiatan->nama_kegiatan }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($kegiatan->tanggal)->format('d M Y') }}</td>
                            <td>
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $tgl = \Carbon\Carbon::parse($kegiatan->tanggal);
                                @endphp
                                @if($tgl->isFuture())
                                    <span class="badge badge-info">Akan Datang</span>
                                @elseif($tgl->isToday())
                                    <span class="badge badge-warning">Hari Ini</span>
                                @else
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p>Belum ada data kegiatan terbaru</p>
                </div>
            @endif
        </div>

    </div>

@endsection