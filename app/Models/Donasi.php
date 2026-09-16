<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Donasi extends Model
{
    use HasFactory;

    protected $table = 'donasi';

    protected $fillable = [
        'kode_donasi',
        'nama_donatur',
        'email',
        'alamat',
        'no_hp',
        'nominal',
        'tanggal',
        'bukti_transfer',
        'status',
        'catatan_admin',
        'keterangan',
        'donatur_id',
        'metode_pembayaran',
        'tampilkan_nama',
    ];

    // Saat ambil data dari DB, format ke d-m-Y
    public function getTanggalDisplayAttribute()
    {
        return $this->tanggal ? Carbon::parse($this->tanggal)->format('d-m-Y') : null;
    }

    // Saat simpan data dari form d-m-Y, ubah ke Y-m-d
    public function setTanggalInputAttribute($value)
    {
        $this->attributes['tanggal'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'integer',
    ];

    public static function generateKode(): string
    {
        do {
            $kode = 'DON-'.strtoupper(Str::random(8));
        } while (self::where('kode_donasi', $kode)->exists());

        return $kode;
    }

    /**
     * Format nominal ke rupiah.
     */
    public function getNominalRupiahAttribute(): string
    {
        return 'Rp '.number_format($this->nominal, 0, ',', '.');
    }

    /**
     * Label & warna badge status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'diterima' => 'success',
            'ditolak' => 'danger',
            default => 'secondary',
        };
    }

    public function donatur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'donatur_id');
    }
}
