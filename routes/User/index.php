<?php 

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\UserviewController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/newsletter', [UserviewController::class, 'storeNewsletter']);
