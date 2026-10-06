<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $fillable = [
        'anak_asuh_id',
        'foto',
        'nama',
        'nama_panggilan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_social_anak',
        'nama_ayah',
        'nama_ibu',
        'tinggal_di_lksa_sejak',
        'sekolah',
        'kelas',
        'tanggal_keluar',
        'pendidikan_terakhir',
        'nama_sekolah_terakhir',
        'pekerjaan',
        'no_hp',
        'alamat',
        'catatan',
    ];

    public function anakAsuh()
    {
        return $this->belongsTo(AnakAsuh::class, 'anak_asuh_id');
    }
}
