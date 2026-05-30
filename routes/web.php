<?php

use Illuminate\Support\Facades\Route;

// Portfolio SPA routes — serve the Vue app for all portfolio paths
Route::get('/', fn () => view('portfolio'))->name('home');
Route::get('/projects/{slug}', fn () => view('portfolio'))->name('project.show');
Route::get('/blog', fn () => view('portfolio'))->name('blog.index');
Route::get('/blog/{slug}', fn () => view('portfolio'))->name('blog.show');
