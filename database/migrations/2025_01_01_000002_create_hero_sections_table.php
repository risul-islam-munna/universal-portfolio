<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Md. Risul Islam Munna');
            $table->string('designation')->default('Full Stack Developer');
            $table->text('bio')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('resume_file')->nullable();
            $table->string('cta_label')->default('Hire Me');
            $table->string('cta_link')->default('#contact');
            $table->json('typing_roles')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
