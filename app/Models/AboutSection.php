<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'bio', 'years_experience', 'projects_completed',
        'clients_served', 'technologies_used', 'profile_photo', 'cv_file',
    ];
}
