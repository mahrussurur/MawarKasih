<?php

if (!function_exists('get_webp_url')) {
    function get_webp_url($originalPath)
    {
        if (empty($originalPath)) {
            return asset('images/logo.webp'); 
        }

        if (strpos($originalPath, 'original/') !== 0) {
            return Storage::url($originalPath);
        }

        $webpPath = str_replace('original/', 'webp/', $originalPath);
        $info = pathinfo($webpPath);
        $webpPath = $info['dirname'] . '/' . $info['filename'] . '.webp';

        return Storage::url($webpPath);
    }
}
