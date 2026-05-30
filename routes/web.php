<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserviewController;

Route::get('/api/categories-with-reports', [UserviewController::class, 'categoriesWithReports']);
Route::get('/api/reports-by-category', [UserviewController::class, 'reportsByCategory']);
Route::get('/api/reports-list', [UserviewController::class, 'getAllReports']);
Route::get('/api/report/{slug}', [UserviewController::class, 'getReportDetail']);
Route::get('/api/press-releases-public', [UserviewController::class, 'pressReleases']);
Route::get('/api/blogs-public', [UserviewController::class, 'blogs']);
Route::get('/api/category/{name}', [UserviewController::class, 'getCategoryDetail']);

Route::get('/', function () {
    return view('welcome');
});
include 'Admin/index.php';
Route::view('/{any}', 'welcome')->where('any', '.*');
