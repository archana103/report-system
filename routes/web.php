<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserviewController;
use App\Http\Controllers\SeoPageController;



Route::post('/request-form', [UserviewController::class, 'storeRequestForm']);
Route::post('/contact-us', [UserviewController::class, 'storeContactForm']);
Route::post('/blog-request', [UserviewController::class, 'storeBlogRequest']);
Route::post('/newsletter', [UserviewController::class, 'storeNewsletter']);


Route::get('/', [SeoPageController::class, 'show']);
include 'Admin/index.php';
include 'Paypal/index.php';
Route::get('storage/{path}', function ($path) {
    return redirect()->away(Storage::disk('s3')->url($path));
})->where('path', '.*');

Route::get('/{any}', [SeoPageController::class, 'show'])->where('any', '.*');

