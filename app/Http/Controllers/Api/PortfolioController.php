<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutSectionResource;
use App\Http\Resources\BlogPostResource;
use App\Http\Resources\BusinessHighlightResource;
use App\Http\Resources\EducationResource;
use App\Http\Resources\ExperienceResource;
use App\Http\Resources\HeroSectionResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SkillResource;
use App\Http\Resources\TestimonialResource;
use App\Http\Resources\ThemeResource;
use App\Models\AboutSection;
use App\Models\BlogPost;
use App\Models\BusinessHighlight;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\HeroSection;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\Theme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PortfolioController extends Controller
{
    public function settings(): JsonResponse
    {
        $s = Setting::forTheme('default');

        return response()->json([
            'site_title' => $s['site_title'] ?? null,
            'tagline' => $s['tagline'] ?? null,
            'meta_description' => $s['meta_description'] ?? null,
            'favicon' => ! empty($s['favicon']) ? \Storage::disk('portfolio')->url($s['favicon']) : null,
            'contact_email' => $s['contact_email'] ?? null,
            'phone' => $s['phone'] ?? null,
            'address' => $s['address'] ?? null,
            'google_analytics_id' => $s['google_analytics_id'] ?? null,
            'social_links' => json_decode($s['social_links'] ?? '[]', true) ?? [],
        ]);
    }

    public function hero(): JsonResponse
    {
        $hero = HeroSection::first() ?? new HeroSection;

        return response()->json(new HeroSectionResource($hero));
    }

    public function about(): JsonResponse
    {
        $about = AboutSection::first() ?? new AboutSection;

        return response()->json(new AboutSectionResource($about));
    }

    public function skills(): AnonymousResourceCollection
    {
        $skills = Skill::orderBy('display_order')->orderBy('category')->get();

        return SkillResource::collection($skills);
    }

    public function services(): AnonymousResourceCollection
    {
        $services = Service::orderBy('display_order')->get();

        return ServiceResource::collection($services);
    }

    public function projects(): AnonymousResourceCollection
    {
        $projects = Project::orderBy('display_order')->orderByDesc('is_featured')->get();

        return ProjectResource::collection($projects);
    }

    public function project(string $slug): JsonResponse
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        return response()->json(new ProjectResource($project));
    }

    public function experience(): AnonymousResourceCollection
    {
        $experience = Experience::orderBy('display_order')->orderByDesc('start_date')->get();

        return ExperienceResource::collection($experience);
    }

    public function education(): AnonymousResourceCollection
    {
        $education = Education::orderBy('display_order')->orderByDesc('start_year')->get();

        return EducationResource::collection($education);
    }

    public function testimonials(): AnonymousResourceCollection
    {
        $testimonials = Testimonial::where('is_active', true)->orderBy('display_order')->get();

        return TestimonialResource::collection($testimonials);
    }

    public function blog(): AnonymousResourceCollection
    {
        $posts = BlogPost::where('is_published', true)
            ->orderByDesc('published_at')
            ->get();

        return BlogPostResource::collection($posts);
    }

    public function blogPost(string $slug): JsonResponse
    {
        $post = BlogPost::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return response()->json(new BlogPostResource($post));
    }

    public function businessHighlight(): JsonResponse
    {
        $business = BusinessHighlight::first();

        if (! $business) {
            return response()->json(null);
        }

        return response()->json(new BusinessHighlightResource($business));
    }

    public function activeTheme(): JsonResponse
    {
        $theme = Theme::where('is_active', true)->first();
        if (! $theme) {
            return response()->json(null);
        }

        return response()->json(new ThemeResource($theme));
    }

    public function allThemes(): AnonymousResourceCollection
    {
        return ThemeResource::collection(Theme::all());
    }

    public function contact(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        return response()->json(['message' => 'Your message has been sent successfully!']);
    }
}
