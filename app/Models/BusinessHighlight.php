<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessHighlight extends Model
{
    protected $fillable = [
        'name', 'tagline', 'logo', 'description',
        'website_url', 'app_store_link', 'play_store_link',
        'features', 'screenshots',
    ];

    protected $casts = [
        'features' => 'array',
        'screenshots' => 'array',
    ];
}
