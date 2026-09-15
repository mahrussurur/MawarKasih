<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanPerkembangan extends Model
{
    use HasFactory;

    protected $table = 'catatan_perkembangan';

    protected $fillable = [
        'anak_asuh_id',
        'pengasuh_id',
        'tanggal',
        'kategori',
        'catatan',
        'foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function anakAsuh()
    {
        return $this->belongsTo(AnakAsuh::class, 'anak_asuh_id');
    }

    public function pengasuh()
    {
        return $this->belongsTo(User::class, 'pengasuh_id');
    }
}
