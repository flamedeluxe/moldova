<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $casts = [
        'content' => 'json',
        'gallery' => 'array'
    ];
}
