<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function uploadAndGenerateWebp(UploadedFile $file, string $folder): string
    {
        $originalPath = $file->store('original/' . $folder, 'public');

        $fullPath = Storage::disk('public')->path($originalPath);
        $image = $this->manager->decodePath($fullPath);

        $filename = pathinfo($originalPath, PATHINFO_FILENAME);
        $webpRelativePath = 'webp/' . $folder . '/' . $filename . '.webp';
        $webpFullPath = Storage::disk('public')->path($webpRelativePath);

        Storage::disk('public')->makeDirectory('webp/' . $folder);

        $image->encode(new WebpEncoder(85))->save($webpFullPath);

        return $originalPath;
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
