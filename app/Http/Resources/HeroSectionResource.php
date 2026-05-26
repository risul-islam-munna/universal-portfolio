<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HeroSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'designation' => $this->designation,
            'bio' => $this->bio,
            'profile_photo' => $this->profile_photo ? Storage::disk('public')->url($this->profile_photo) : null,
            'resume_url' => $this->resume_file ? Storage::disk('public')->url($this->resume_file) : null,
            'cta_label' => $this->cta_label,
            'cta_link' => $this->cta_link,
            'typing_roles' => $this->typing_roles ?? [],
        ];
    }
}
