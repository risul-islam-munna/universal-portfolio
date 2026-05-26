<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'slug', 'thumbnail', 'gallery', 'description',
        'tech_stack', 'project_url', 'github_url', 'category',
        'is_featured', 'display_order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'tech_stack' => 'array',
        'is_featured' => 'boolean',
    ];
}
