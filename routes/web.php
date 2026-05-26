<?php

use Illuminate\Support\Facades\Route;

// Portfolio SPA routes — serve the Vue app for all portfolio paths
Route::get('/', fn () => view('portfolio'))->name('home');
Route::get('/projects/{slug}', fn () => view('portfolio'))->name('project.show');
Route::get('/blog', fn () => view('portfolio'))->name('blog.index');
Route::get('/blog/{slug}', fn () => view('portfolio'))->name('blog.show');

// Auth & dashboard routes (kept for Filament user management)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
