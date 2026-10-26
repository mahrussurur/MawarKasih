<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /** @var list<string> */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * Field yang disembunyikan saat serialisasi (misal ke JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data field.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Nama tampilan selalu dibaca dari profil yang sesuai dengan role akun.
     */
    public function getNamaAttribute(): string
    {
        $profile = $this->role === 'donatur'
            ? $this->profilDonatur
            : $this->profilPegawai;

        return $profile?->nama ?? $this->username;
    }

    /**
     * Profil pegawai untuk admin, ketua, bendahara.
     */
    public function profilPegawai(): HasOne
    {
        return $this->hasOne(ProfilPegawai::class);
    }

    public function profilDonatur(): HasOne
    {
        return $this->hasOne(ProfilDonatur::class);
    }

    public function donasi(): HasMany
    {
        return $this->hasMany(Donasi::class, 'donatur_id');
    }
}
