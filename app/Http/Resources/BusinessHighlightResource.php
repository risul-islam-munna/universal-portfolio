<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BusinessHighlightResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'tagline' => $this->tagline,
            'logo' => $this->logo ? Storage::disk('public')->url($this->logo) : null,
            'description' => $this->description,
            'website_url' => $this->website_url,
            'app_store_link' => $this->app_store_link,
            'play_store_link' => $this->play_store_link,
            'features' => $this->features ?? [],
            'screenshots' => collect($this->screenshots ?? [])->map(fn ($s) => Storage::disk('public')->url($s))->values()->all(),
        ];
    }
}
