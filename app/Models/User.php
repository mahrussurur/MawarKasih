<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Field yang boleh diisi secara massal (mass assignment).
     * Hapus 'email' karena kita pakai 'username'.
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'foto',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'jabatan',
        'jenis_kelamin',
        'no_hp',
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
            'password' => 'hashed',
        ];
    }

    /**
     * Donasi yang dimiliki oleh user ini (sebagai donatur).
     */
    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'donatur_id');
    }
}