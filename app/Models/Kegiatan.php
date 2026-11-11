<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    // Tambahkan baris ini: Daftar kolom yang BOLEH diisi lewat form
    protected $fillable = [
        'nama_kegiatan',
        'tanggal_pelaksanaan',
        'deskripsi',
        'foto_dokumentasi',
    ];

    /**
     * Bersihkan paragraf/tag kosong di awal dan akhir teks deskripsi
     * serta spasi/newline berlebih agar tidak menimbulkan jarak vertikal kosong.
     */
    public function getDeskripsiAttribute($value): ?string
    {
        if (empty($value)) {
            return $value;
        }

        // Hapus BOM dan zero-width character
        $value = preg_replace('/[\x{FEFF}\x{200B}\x{200C}\x{200D}]/u', '', $value);
        $value = trim($value);

        // Pola karakter kosong (spasi, newline, &nbsp;, &#160;, \xa0, atau span kosong)
        $emptyInner = '(?:[ \t\r\n]|<br\s*\/?>|&nbsp;|&#160;|\x{00a0}|<span>(?:[ \t\r\n]|<br\s*\/?>|&nbsp;|&#160;|\x{00a0})*<\/span>)*';

        // Bersihkan tag/paragraf kosong di awal
        do {
            $before = $value;
            $value = preg_replace('/^(\s*<(p|div|h[1-6]|blockquote)[^>]*>' . $emptyInner . '<\/\2>\s*|<br\s*\/?>|\s)+/iu', '', $value);
        } while ($value !== $before && !empty($value));

        // Bersihkan tag/paragraf kosong di akhir
        do {
            $before = $value;
            $value = preg_replace('/(\s*<(p|div|h[1-6]|blockquote)[^>]*>' . $emptyInner . '<\/\2>\s*|<br\s*\/?>|\s)+$/iu', '', $value);
        } while ($value !== $before && !empty($value));

        // Hilangkan whitespace/newline antar tag penutup dan pembuka
        $value = preg_replace('/>\s+</u', '><', $value);

        return trim($value);
    }
}
