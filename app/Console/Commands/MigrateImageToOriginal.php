<?php

namespace App\Console\Commands;

use App\Models\AnakAsuh;
use App\Models\Donasi;
use App\Models\Galeri;
use App\Models\Kegiatan;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateImageToOriginal extends Command
{
    protected $signature = 'image:migrate';

    protected $description = 'Memindahkan gambar lama ke struktur original/ dan memperbarui path database';

    public function handle()
    {
        $this->info('Memulai migrasi gambar lama ke folder original/ ...');

        $models = [
            ['class' => AnakAsuh::class, 'column' => 'foto', 'folder' => 'anak_asuh'],
            ['class' => Kegiatan::class, 'column' => 'foto_dokumentasi', 'folder' => 'kegiatan'],
            ['class' => Galeri::class, 'column' => 'foto', 'folder' => 'galeri'],
            ['class' => Donasi::class, 'column' => 'bukti_transfer', 'folder' => 'bukti_transfer'],
        ];

        foreach ($models as $modelConfig) {
            $class = $modelConfig['class'];
            $column = $modelConfig['column'];
            $folder = $modelConfig['folder'];

            $this->info("Memproses model {$class}...");

            $records = $class::all();
            $count = 0;

            foreach ($records as $record) {
                $oldPath = $record->$column;

                if (empty($oldPath) || str_starts_with($oldPath, 'original/')) {
                    continue;
                }
                if (Storage::disk('public')->exists($oldPath)) {
                    $newPath = 'original/'.$oldPath;
                    Storage::disk('public')->makeDirectory('original/'.dirname($oldPath));
                    Storage::disk('public')->move($oldPath, $newPath);

                    $record->$column = $newPath;
                    $record->save();

                    $count++;
                }
            }
            $this->info("Berhasil migrasi {$count} data untuk model {$class}.");
        }

        $this->info('Migrasi selesai!');
    }
}
