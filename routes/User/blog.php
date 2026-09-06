<?php

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\UserviewController;

Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.show');

Route::post('/blog-request', [UserviewController::class, 'storeBlogRequest']);