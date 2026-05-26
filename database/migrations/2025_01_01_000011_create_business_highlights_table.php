<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_highlights', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Bee Hook');
            $table->string('tagline')->nullable();
            $table->string('logo')->nullable();
            $table->longText('description')->nullable();
            $table->string('website_url')->nullable();
            $table->string('app_store_link')->nullable();
            $table->string('play_store_link')->nullable();
            $table->json('features')->nullable();
            $table->json('screenshots')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_highlights');
    }
};
