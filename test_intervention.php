<?php
require __DIR__ . '/vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

try {
    $manager = new ImageManager(new Driver());
    // decode the image
    $img = $manager->decodePath(__DIR__ . '/public/images/logo.webp');
    echo "Width: " . $img->width() . "\n";

    // encode to webp
    $webpPath = __DIR__ . '/test.webp';
    
    // In v3 it was toWebp. Let's see what works.
    $img->encode(new WebpEncoder(85))->save($webpPath);
    echo "Saved to $webpPath\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
