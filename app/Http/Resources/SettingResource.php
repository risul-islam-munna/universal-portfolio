<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'site_title' => $this->site_title,
            'tagline' => $this->tagline,
            'meta_description' => $this->meta_description,
            'logo' => $this->logo ? asset('storage/'.$this->logo) : null,
            'favicon' => $this->favicon ? asset('storage/'.$this->favicon) : null,
            'social' => [
                'github' => $this->github_url,
                'linkedin' => $this->linkedin_url,
                'facebook' => $this->facebook_url,
                'twitter' => $this->twitter_url,
            ],
            'contact_email' => $this->contact_email,
            'phone' => $this->phone,
            'address' => $this->address,
            'google_analytics_id' => $this->google_analytics_id,
        ];
    }
}
