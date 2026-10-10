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

if (!function_exists('seo_image')) {
    function seo_image($path = null, $default = null) {
        if (!empty($path)) {
            return site_image($path);
        }
        if (!empty($default)) {
            return site_image($default);
        }
        $site = \Illuminate\Support\Facades\View::shared('site');
        if (!empty($site['seo_default_og_image'])) {
            return site_image($site['seo_default_og_image']);
        }
        if (!empty($site['logo_path'])) {
            return site_image($site['logo_path']);
        }
        return asset('favicon.ico');
    }
}

if (!function_exists('seo_url')) {
    function seo_url($url = null) {
        if (!empty($url)) {
            if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
                return $url;
            }
            return url($url);
        }
        return url()->current();
    }
}

