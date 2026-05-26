<?php

namespace App\Http\Resources;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $s = Setting::forTheme('default');

        return [
            'site_title' => $s['site_title'] ?? null,
            'tagline' => $s['tagline'] ?? null,
            'meta_description' => $s['meta_description'] ?? null,
            'contact_email' => $s['contact_email'] ?? null,
            'phone' => $s['phone'] ?? null,
            'address' => $s['address'] ?? null,
            'google_analytics_id' => $s['google_analytics_id'] ?? null,
            'social_links' => json_decode($s['social_links'] ?? '[]', true) ?? [],
        ];
    }
}
