<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail ? Storage::disk('public')->url($this->thumbnail) : null,
            'gallery' => collect($this->gallery ?? [])->map(fn ($img) => Storage::disk('public')->url($img))->values()->all(),
            'description' => $this->description,
            'tech_stack' => $this->tech_stack ?? [],
            'project_url' => $this->project_url,
            'github_url' => $this->github_url,
            'category' => $this->category,
            'is_featured' => $this->is_featured,
        ];
    }
}
