<?php

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Portfolio API', function () {
    describe('GET /api/v1/settings', function () {
        it('returns settings with expected keys', function () {
            Setting::setValue('site_title', 'Test Portfolio');
            Setting::setValue('contact_email', 'test@example.com');
            Setting::setValue('social_links', json_encode([]));

            $this->getJson('/api/v1/settings')
                ->assertOk()
                ->assertJsonStructure(['site_title', 'tagline', 'contact_email', 'favicon', 'social_links'])
                ->assertJsonPath('site_title', 'Test Portfolio')
                ->assertJsonPath('contact_email', 'test@example.com');
        });

        it('returns decoded social_links array', function () {
            $links = [['name' => 'GitHub', 'url' => 'https://github.com/test', 'svg_icon' => '<svg/>']];
            Setting::setValue('social_links', json_encode($links));

            $response = $this->getJson('/api/v1/settings')->assertOk();
            expect($response->json('social_links'))->toBeArray()->toHaveCount(1);
            expect($response->json('social_links.0.name'))->toBe('GitHub');
        });

        it('returns null favicon when none is set', function () {
            $this->getJson('/api/v1/settings')
                ->assertOk()
                ->assertJsonPath('favicon', null);
        });
    });

    describe('GET /api/v1/hero', function () {
        it('returns hero data', function () {
            $this->getJson('/api/v1/hero')
                ->assertOk()
                ->assertJsonStructure(['name', 'designation', 'bio']);
        });
    });

    describe('GET /api/v1/skills', function () {
        it('returns skills collection', function () {
            $this->getJson('/api/v1/skills')
                ->assertOk()
                ->assertJsonStructure(['data']);
        });
    });

    describe('GET /api/v1/business-highlight', function () {
        it('returns null when no business highlight exists', function () {
            $this->getJson('/api/v1/business-highlight')
                ->assertOk()
                ->assertExactJson([]);
        });
    });

    describe('POST /api/v1/contact', function () {
        it('stores a contact message', function () {
            $this->postJson('/api/v1/contact', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'message' => 'Hello from a test!',
            ])->assertOk()->assertJsonPath('message', 'Your message has been sent successfully!');

            $this->assertDatabaseHas('contact_messages', ['email' => 'john@example.com']);
        });

        it('validates required fields', function () {
            $this->postJson('/api/v1/contact', [])
                ->assertUnprocessable()
                ->assertJsonValidationErrors(['name', 'email', 'message']);
        });

        it('validates email format', function () {
            $this->postJson('/api/v1/contact', [
                'name' => 'John',
                'email' => 'not-an-email',
                'message' => 'Test',
            ])->assertUnprocessable()
                ->assertJsonValidationErrors(['email']);
        });
    });
});
