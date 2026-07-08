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
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
