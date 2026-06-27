<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteParameter extends Model
{
    protected $table = 'site_parameters';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'value', 'label', 'category'];
}
