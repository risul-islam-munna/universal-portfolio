<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->comment('URL-safe identifier, e.g. default, photographer');
            $table->string('component', 100)->default('default')->comment('Theme package/directory name loaded by the frontend registry');
            $table->boolean('is_active')->default(false);
            $table->json('config')->nullable()->comment('Per-theme config stored as JSON (colours, fonts, layout overrides)');
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
