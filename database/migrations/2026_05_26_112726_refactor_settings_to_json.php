<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->json('data')->nullable()->after('id');
        });

        DB::table('settings')->get()->each(function ($row) {
            DB::table('settings')->where('id', $row->id)->update([
                'data' => json_encode([
                    'site_title' => $row->site_title ?? null,
                    'tagline' => $row->tagline ?? null,
                    'meta_description' => $row->meta_description ?? null,
                    'logo' => $row->logo ?? null,
                    'favicon' => $row->favicon ?? null,
                    'github_url' => $row->github_url ?? null,
                    'linkedin_url' => $row->linkedin_url ?? null,
                    'facebook_url' => $row->facebook_url ?? null,
                    'twitter_url' => $row->twitter_url ?? null,
                    'contact_email' => $row->contact_email ?? null,
                    'phone' => $row->phone ?? null,
                    'address' => $row->address ?? null,
                    'google_analytics_id' => $row->google_analytics_id ?? null,
                    'storage_driver' => 'local',
                ]),
            ]);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_title', 'tagline', 'meta_description', 'logo', 'favicon',
                'github_url', 'linkedin_url', 'facebook_url', 'twitter_url',
                'contact_email', 'phone', 'address', 'google_analytics_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('site_title')->default('Portfolio');
            $table->string('tagline')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('google_analytics_id')->nullable();
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('data');
        });
    }
};
