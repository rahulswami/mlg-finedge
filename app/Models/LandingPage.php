<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'layout_type',
        'meta_description',
        'content',
        'schema_markup',
        'meta_title',
        'meta_keywords',
        'canonical_url',
        'meta_robots',
        'og_image',
        'h1_tag',
        'image_alt',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
