<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuanganBulanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'bulan',
        'saldo_awal',
        'total_pemasukan',
        'total_pengeluaran',
        'saldo_akhir',
        'status',
        'submitted_at',
        'submitted_by',
        'approved_at',
        'approved_by',
        'returned_at',
        'returned_by',
        'catatan_return',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function returner()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}

