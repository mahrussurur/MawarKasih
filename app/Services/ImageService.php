<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use RuntimeException;
use Throwable;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        if (! extension_loaded('gd') || ! function_exists('imagewebp')) {
            throw new RuntimeException('Ekstensi GD dengan dukungan WebP wajib aktif untuk memproses gambar.');
        }

        $this->manager = new ImageManager(new Driver());
    }

    public function uploadAndGenerateWebp(UploadedFile $file, string $folder): string
    {
        $disk = Storage::disk('public');
        $originalPath = null;
        $webpRelativePath = null;

        try {
            $originalPath = $file->store('original/' . $folder, 'public');
            if (! is_string($originalPath) || $originalPath === '') {
                throw new RuntimeException('Gagal menyimpan gambar asli.');
            }

            $fullPath = $disk->path($originalPath);
            $image = $this->manager->decodePath($fullPath);

            $filename = pathinfo($originalPath, PATHINFO_FILENAME);
            $webpRelativePath = 'webp/' . $folder . '/' . $filename . '.webp';
            $webpFullPath = $disk->path($webpRelativePath);

            $disk->makeDirectory('webp/' . $folder);
            $image->encode(new WebpEncoder(85))->save($webpFullPath);

            if (! $disk->exists($webpRelativePath)) {
                throw new RuntimeException('Gagal membuat gambar WebP.');
            }

            return $originalPath;
        } catch (Throwable $exception) {
            if ($webpRelativePath && $disk->exists($webpRelativePath)) {
                $disk->delete($webpRelativePath);
            }

            if ($originalPath && $disk->exists($originalPath)) {
                $disk->delete($originalPath);
            }

            throw $exception;
        }
    }

    public function deleteImage(?string $originalPath)
    {
        if (empty($originalPath)) {
            return;
        }

        if (Storage::disk('public')->exists($originalPath)) {
            Storage::disk('public')->delete($originalPath);
        }

        $webpPath = str_replace('original/', 'webp/', $originalPath);
        $info = pathinfo($webpPath);
        $webpPath = $info['dirname'] . '/' . $info['filename'] . '.webp';

        if (Storage::disk('public')->exists($webpPath)) {
            Storage::disk('public')->delete($webpPath);
        }
    }
}
