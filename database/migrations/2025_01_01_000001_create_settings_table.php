<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('theme', 100)->default('default')->comment('Theme slug this setting belongs to');
            $table->string('key', 200)->comment('Setting key, e.g. site_title, github_url');
            $table->longText('value')->nullable()->comment('Setting value (plain string or JSON-encoded)');
            $table->boolean('status')->default(true)->comment('1 = active, 0 = disabled');
            $table->timestamps();

            $table->unique(['theme', 'key']);
            $table->index('theme');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
