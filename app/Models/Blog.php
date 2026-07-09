<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $fillable = ['slug', 'title', 'category', 'summary', 'content', 'image_path', 'published_at', 'schema_markup'];
    protected $casts = [
        'published_at' => 'datetime',
    ];
}
