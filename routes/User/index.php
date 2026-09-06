<?php

use App\Http\Controllers\Frontend\HomeController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/newsletter', [HomeController::class, 'storeNewsletter']);
