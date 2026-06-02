<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Donatur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'donaturs';
    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'status',
        'password'
    ];
    
    protected $hidden = [
        'password',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\DonaturResetPassword($token));
    }
}
