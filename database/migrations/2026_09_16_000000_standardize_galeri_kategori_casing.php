<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('galeris')->where('kategori', 'umum')->update(['kategori' => 'Umum']);
        DB::table('galeris')->where('kategori', 'fasilitas')->update(['kategori' => 'Fasilitas']);
    }

    public function down(): void
    {
        DB::table('galeris')->where('kategori', 'Umum')->update(['kategori' => 'umum']);
        DB::table('galeris')->where('kategori', 'Fasilitas')->update(['kategori' => 'fasilitas']);
    }
};
