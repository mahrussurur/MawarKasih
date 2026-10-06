<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnakAsuh extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'anak_asuh';

    protected $fillable = [
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
    ];

    public function alumni()
    {
        return $this->hasOne(Alumni::class);
    }
}
