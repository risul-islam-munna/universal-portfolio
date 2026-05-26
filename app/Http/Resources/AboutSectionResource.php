<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AboutSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'bio' => $this->bio,
            'stats' => [
                'years_experience' => $this->years_experience,
                'projects_completed' => $this->projects_completed,
                'clients_served' => $this->clients_served,
                'technologies_used' => $this->technologies_used,
            ],
            'profile_photo' => $this->profile_photo ? Storage::disk('public')->url($this->profile_photo) : null,
            'cv_url' => $this->cv_file ? Storage::disk('public')->url($this->cv_file) : null,
        ];
    }
}
