<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BlogPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'cover_image' => $this->cover_image ? Storage::disk('public')->url($this->cover_image) : null,
            'content' => $this->content,
            'tags' => $this->tags ?? [],
            'published_at' => $this->published_at?->toDateTimeString(),
            'is_published' => $this->is_published,
        ];
    }
}
