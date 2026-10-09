<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKeuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'kategori',
        'nominal',
        'keterangan',
        'tanggal',
        'donasi_id',
        'dicatat_oleh',
        'bukti_transaksi'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function donasi()
    {
        return $this->belongsTo(Donasi::class);
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
