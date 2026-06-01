<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengasuh extends Model
{
    use HasFactory;

    protected $table = 'pengasuh';
    protected $fillable = [
        'foto',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'jabatan',
        'jenis_kelamin',
        'no_hp'
    ];
}