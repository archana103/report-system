<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserviewController;

Route::get('/api/categories-with-reports', [UserviewController::class, 'categoriesWithReports']);
Route::get('/api/press-releases-public', [UserviewController::class, 'pressReleases']);

Route::get('/', function () {
    return view('welcome');
});
include 'Admin/index.php';
Route::view('/{any}', 'welcome')->where('any', '.*');
