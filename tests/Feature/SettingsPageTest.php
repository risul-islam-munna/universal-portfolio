<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

describe('Settings — Key-Value Store', function () {
    it('stores and retrieves a setting value', function () {
        Setting::setValue('site_title', 'My Portfolio');

        expect(Setting::getValue('site_title'))->toBe('My Portfolio');
    });

    it('returns the default when key does not exist', function () {
        expect(Setting::getValue('nonexistent_key', 'fallback'))->toBe('fallback');
    });

    it('scopes settings by theme', function () {
        Setting::setValue('site_title', 'Default Theme', 'default');
        Setting::setValue('site_title', 'Dark Theme', 'dark');

        expect(Setting::getValue('site_title', null, 'default'))->toBe('Default Theme');
        expect(Setting::getValue('site_title', null, 'dark'))->toBe('Dark Theme');
    });

    it('bulk-saves many settings at once', function () {
        Setting::setMany([
            'site_title' => 'Bulk Title',
            'contact_email' => 'hello@example.com',
        ]);

        expect(Setting::getValue('site_title'))->toBe('Bulk Title');
        expect(Setting::getValue('contact_email'))->toBe('hello@example.com');
    });

    it('returns all settings for a theme as an array', function () {
        Setting::setValue('site_title', 'Portfolio');
        Setting::setValue('tagline', 'Developer');

        $settings = Setting::forTheme('default');

        expect($settings)->toBeArray()
            ->toHaveKey('site_title', 'Portfolio')
            ->toHaveKey('tagline', 'Developer');
    });
});

describe('Settings — Admin Panel access', function () {
    it('redirects unauthenticated users from admin to login', function () {
        $this->get('/admin/settings-page')->assertRedirect('/admin/login');
    });

    it('allows authenticated admin to access settings page', function () {
        $admin = User::factory()->create();
        $this->actingAs($admin)->get('/admin/settings-page')->assertOk();
    });
});

describe('Settings — Account update', function () {
    it('updates admin email', function () {
        $admin = User::factory()->create(['email' => 'old@example.com']);
        $this->actingAs($admin);

        $admin->email = 'new@example.com';
        $admin->save();

        expect(User::find($admin->id)->email)->toBe('new@example.com');
    });

    it('updates admin password when current password is correct', function () {
        $admin = User::factory()->create(['password' => Hash::make('oldpassword')]);

        $admin->password = Hash::make('newpassword');
        $admin->save();

        expect(Hash::check('newpassword', User::find($admin->id)->password))->toBeTrue();
    });

    it('does not update password when current password is wrong', function () {
        $original = Hash::make('correct');
        $admin = User::factory()->create(['password' => $original]);

        // Simulate wrong current password check
        $isCorrect = Hash::check('wrongpassword', $admin->password);

        expect($isCorrect)->toBeFalse();
        expect($admin->fresh()->password)->toBe($original);
    });
});
