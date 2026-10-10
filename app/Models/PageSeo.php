<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_key',
        'page_name',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'meta_robots',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'h1_tag',
        'hero_image_alt',
        'schema_markup',
        'is_active',
    ];

    public function getImageAltAttribute()
    {
        return $this->attributes['hero_image_alt'] ?? null;
    }

    public function setImageAltAttribute($value)
    {
        $this->attributes['hero_image_alt'] = $value;
    }

    public static $corePages = [
        'home' => 'Home Page',
        'about' => 'About Us',
        'services' => 'Services Directory',
        'compare' => 'Compare Loans',
        'testimonials' => 'Testimonials',
        'faq' => 'FAQ & Help',
        'blog' => 'Blog Index',
        'contact' => 'Contact Us',
        'thank_you' => 'Thank You Page',
    ];

    public static function getForPage($pageKey)
    {
        return static::where('page_key', $pageKey)->first();
    }
}
