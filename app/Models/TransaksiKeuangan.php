<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKeuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'nominal',
        'keterangan',
        'tanggal',
        'donasi_id',
        'dicatat_oleh'
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
