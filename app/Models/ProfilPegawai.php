<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilPegawai extends Model
{
    use HasFactory;

    protected $table = 'profil_pegawai';

    protected $fillable = [
        'user_id',
        'foto',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jabatan',
        'jenis_kelamin',
        'no_hp',
        'alamat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
