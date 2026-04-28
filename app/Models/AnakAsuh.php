<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnakAsuh extends Model
{
    use HasFactory;

    protected $table = 'anak_asuh';
    protected $fillable = [
        'foto', 'nama', 'tempat_lahir', 'tanggal_lahir', 
        'jenis_kelamin', 'status_social_anak', 'nama_ayah', 'nama_ibu'
    ];
}
