<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComparisonBank extends Model
{
    protected $fillable = [
        'name',
        'home_rate',
        'personal_rate',
        'business_rate',
        'fee_percent',
        'sector',
        'sort_order',
    ];

    protected $casts = [
        'home_rate' => 'float',
        'personal_rate' => 'float',
        'business_rate' => 'float',
        'fee_percent' => 'float',
        'sort_order' => 'integer',
    ];
}
