<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    // Tambahkan baris ini: Daftar kolom yang BOLEH diisi lewat form
    protected $fillable = [
        'nama_kegiatan',
        'tanggal_pelaksanaan',
        'deskripsi',
        'foto_dokumentasi',
    ];
}