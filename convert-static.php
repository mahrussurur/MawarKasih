<?php
$directory = __DIR__ . '/public/images';

function convertImagesToWebP($dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    
    foreach ($iterator as $file) {
        if ($file->isFile()) {
            $ext = strtolower($file->getExtension());
            if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $filePath = $file->getRealPath();
                $filename = pathinfo($filePath, PATHINFO_FILENAME);
                $dirPath = dirname($filePath);
                $webpPath = $dirPath . '/' . $filename . '.webp';
                
                // Jika sudah ada webp, lewati
                if (file_exists($webpPath)) {
                    continue;
                }
                
                $img = null;
                if ($ext === 'jpg' || $ext === 'jpeg') {
                    $img = @imagecreatefromjpeg($filePath);
                } elseif ($ext === 'png') {
                    $img = @imagecreatefrompng($filePath);
                    if ($img) {
                        imagepalettetotruecolor($img);
                        imagealphablending($img, true);
                        imagesavealpha($img, true);
                    }
                }
                
                if ($img !== false && $img !== null) {
                    imagewebp($img, $webpPath, 85);
                    imagedestroy($img);
                    
                    // Verifikasi apakah berhasil dibuat sebelum menghapus yang asli
                    if (file_exists($webpPath)) {
                        unlink($filePath);
                        echo "Converted: " . basename($filePath) . " -> " . basename($webpPath) . "\n";
                    } else {
                        echo "Failed to create webp for: " . basename($filePath) . "\n";
                    }
                } else {
                    echo "Failed to open image: " . basename($filePath) . "\n";
                }
            }
        }
    }
}

echo "Starting conversion...\n";
convertImagesToWebP($directory);
echo "Conversion complete.\n";
