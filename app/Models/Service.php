<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title', 'icon', 'description', 'is_featured', 'display_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}
