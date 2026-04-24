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
        'username',
        'password',
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
}