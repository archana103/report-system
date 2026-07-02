<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserviewController;
use App\Http\Controllers\SeoPageController;

Route::get('/api/categories-with-reports', [UserviewController::class, 'categoriesWithReports']);
Route::get('/api/reports-by-category', [UserviewController::class, 'reportsByCategory']);
Route::get('/api/reports-list', [UserviewController::class, 'getAllReports']);
Route::get('/api/report/{slug}', [UserviewController::class, 'getReportDetail']);
Route::get('/api/blog/{slug}', [UserviewController::class, 'getBlogDetail']);
Route::get('/api/press-releases-public', [UserviewController::class, 'pressReleases']);
Route::get('/api/blogs-public', [UserviewController::class, 'blogs']);
Route::get('/api/blogs-list', [UserviewController::class, 'getAllBlogs']);
Route::get('/api/press-releases-list', [UserviewController::class, 'getAllPressReleases']);
Route::get('/api/press-release/{slug}', [UserviewController::class, 'getPressReleaseDetail']);
Route::get('/api/category/{name}', [UserviewController::class, 'getCategoryDetail']);
Route::get('/api/categories-dropdown', [UserviewController::class, 'categoriesDropdown']);
Route::post('/api/request-form', [UserviewController::class, 'storeRequestForm']);
Route::post('/api/contact-us', [UserviewController::class, 'storeContactForm']);
Route::post('/api/blog-request', [UserviewController::class, 'storeBlogRequest']);
Route::get('/api/pricings-active', [App\Http\Controllers\Admin\PricingController::class, 'getActivePricings']);
Route::get('/api/search-predictive', [UserviewController::class, 'predictiveSearch']);

Route::get('/', [SeoPageController::class, 'show']);
include 'Admin/index.php';
include 'Paypal/index.php';
Route::get('storage/{path}', function ($path) {
    return redirect()->away(Storage::disk('s3')->url($path));
})->where('path', '.*');

Route::get('/{any}', [SeoPageController::class, 'show'])->where('any', '.*');

