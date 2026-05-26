<?php

use App\Http\Controllers\Api\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('settings', [PortfolioController::class, 'settings']);
    Route::get('hero', [PortfolioController::class, 'hero']);
    Route::get('about', [PortfolioController::class, 'about']);
    Route::get('skills', [PortfolioController::class, 'skills']);
    Route::get('services', [PortfolioController::class, 'services']);
    Route::get('projects', [PortfolioController::class, 'projects']);
    Route::get('projects/{slug}', [PortfolioController::class, 'project']);
    Route::get('experience', [PortfolioController::class, 'experience']);
    Route::get('education', [PortfolioController::class, 'education']);
    Route::get('testimonials', [PortfolioController::class, 'testimonials']);
    Route::get('blog', [PortfolioController::class, 'blog']);
    Route::get('blog/{slug}', [PortfolioController::class, 'blogPost']);
    Route::get('business-highlight', [PortfolioController::class, 'businessHighlight']);
    Route::get('active-theme', [PortfolioController::class, 'activeTheme']);
    Route::get('themes', [PortfolioController::class, 'allThemes']);
    Route::post('contact', [PortfolioController::class, 'contact']);
});
