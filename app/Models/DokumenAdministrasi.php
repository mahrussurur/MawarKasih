<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenAdministrasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'nomor_dokumen',
        'jenis_dokumen',
        'file_path',
        'keterangan',
        'tanggal_dokumen',
        'diupload_oleh'
    ];

    protected $casts = [
        'tanggal_dokumen' => 'date',
    ];

    public function pengupload()
    {
        return $this->belongsTo(User::class, 'diupload_oleh');
    }
}
