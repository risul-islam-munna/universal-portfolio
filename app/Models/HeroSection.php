<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'name', 'designation', 'bio', 'profile_photo',
        'resume_file', 'cta_label', 'cta_link', 'typing_roles',
    ];

    protected $casts = [
        'typing_roles' => 'array',
    ];
}
