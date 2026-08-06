<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class GenerateWebpImage extends Command
{
    protected $signature = 'image:generate-webp';

    protected $description = 'Menghasilkan versi WebP untuk semua gambar yang ada di folder original/';

    public function handle()
    {
        $this->info('Memulai konversi gambar original ke WebP...');

        $manager = new ImageManager(new Driver());
        
        $originalDisk = Storage::disk('public');
        $files = $originalDisk->allFiles('original');

        $count = 0;
        foreach ($files as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $webpPath = str_replace('original/', 'webp/', $file);
                $info = pathinfo($webpPath);
                $webpPath = $info['dirname'] . '/' . $info['filename'] . '.webp';
                $originalDisk->makeDirectory($info['dirname']);

                try {
                    $fullOriginalPath = $originalDisk->path($file);
                    $fullWebpPath = $originalDisk->path($webpPath);
                    
                    $image = $manager->decodePath($fullOriginalPath);
                    $image->encode(new WebpEncoder(85))->save($fullWebpPath);
                    
                    $count++;
                    $this->line("Konversi: {$file} -> {$webpPath}");
                } catch (\Exception $e) {
                    $this->error("Gagal memproses {$file}: " . $e->getMessage());
                }
            }
        }

        $this->info("Berhasil mengonversi {$count} gambar ke WebP!");
    }
}
