<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'service_name',
        'hero_category',
        'hero_title',
        'hero_subtitle',
        'rate_value',
        'max_loan',
        'tenure',
        'intro_title',
        'intro_content',
        'eligibility_criteria',
        'documents_required',
        'tips_title',
        'tips_content',
        'faqs',
        'badge',
        'summary',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'faqs' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
