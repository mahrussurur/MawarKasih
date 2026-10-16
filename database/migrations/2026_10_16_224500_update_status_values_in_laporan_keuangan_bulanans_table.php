<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('laporan_keuangan_bulanans')->where('status', 'submitted')->update(['status' => 'diajukan']);
        DB::table('laporan_keuangan_bulanans')->where('status', 'returned')->update(['status' => 'dikembalikan']);
        DB::table('laporan_keuangan_bulanans')->where('status', 'approved')->update(['status' => 'disetujui']);
    }

    public function down(): void
    {
        DB::table('laporan_keuangan_bulanans')->where('status', 'diajukan')->update(['status' => 'submitted']);
        DB::table('laporan_keuangan_bulanans')->where('status', 'dikembalikan')->update(['status' => 'returned']);
        DB::table('laporan_keuangan_bulanans')->where('status', 'disetujui')->update(['status' => 'approved']);
    }
};
