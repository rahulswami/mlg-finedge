<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $fillable = [
        'slug',
        'title',
        'category',
        'summary',
        'content',
        'image_path',
        'published_at',
        'schema_markup',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'meta_robots',
        'og_image',
        'h1_tag',
        'image_alt',
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
