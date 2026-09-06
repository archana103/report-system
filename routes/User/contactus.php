<?php

use App\Http\Controllers\Frontend\ContactUsController;
use App\Http\Controllers\UserviewController;


Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact');

Route::post('/contact-us', [UserviewController::class, 'storeContactForm']);