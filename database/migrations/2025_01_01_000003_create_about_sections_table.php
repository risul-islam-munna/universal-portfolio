<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->longText('bio');
            $table->integer('years_experience')->default(7);
            $table->integer('projects_completed')->default(150);
            $table->integer('clients_served')->default(80);
            $table->integer('technologies_used')->default(30);
            $table->string('profile_photo')->nullable();
            $table->string('cv_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
