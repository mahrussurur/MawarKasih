<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Donasi extends Model
{
    use HasFactory;

    protected $table = 'donasi';

    protected $fillable = [
        'kode_donasi',
        'nama_donatur',
        'no_hp',
        'nominal',
        'tanggal',
        'bukti_transfer',
        'status',
        'catatan_admin',
        'keterangan',
        'donatur_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'integer',
    ];

    /**
     * Generate kode donasi unik: DON-YYYYMMDD-XXXX
     * Dipanggil saat membuat record baru.
     */
    public static function generateKode(): string
    {
        do {
            $kode = 'DON-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        } while (self::where('kode_donasi', $kode)->exists());

        return $kode;
    }

    /**
     * Format nominal ke rupiah.
     */
    public function getNominalRupiahAttribute(): string
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }

    /**
     * Label & warna badge status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'  => 'Pending',
            'valid'    => 'Valid',
            'ditolak'  => 'Ditolak',
            default    => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'valid'   => 'success',
            'ditolak' => 'danger',
            default   => 'secondary',
        };
    }
}