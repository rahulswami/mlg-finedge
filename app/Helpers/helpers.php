<?php

if (!function_exists('site_image')) {
    function site_image($path) {
        if (empty($path)) {
            return '';
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '//')) {
            return $path;
        }
        return asset('storage/' . $path);
    }
}
