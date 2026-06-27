<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{
    protected $table = 'page_contents';
    public $incrementing = false;
    protected $fillable = ['page', 'section', 'key', 'value'];
}
