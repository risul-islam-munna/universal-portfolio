<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name', 'designation', 'company', 'avatar',
        'message', 'rating', 'is_active', 'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
