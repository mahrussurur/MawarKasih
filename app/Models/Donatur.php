<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    use HasFactory;

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
}
