<?php
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ReportCategoryController;
use App\Http\Controllers\Admin\ReportListController;

Route::post('/admin/login', [AdminAuthController::class, 'login']);

// Report Categories
Route::get('/admin/report-categories', [ReportCategoryController::class, 'index']);
Route::post('/admin/report-categories', [ReportCategoryController::class, 'store']);
Route::put('/admin/report-categories/{id}', [ReportCategoryController::class, 'update']);
Route::delete('/admin/report-categories/{id}', [ReportCategoryController::class, 'destroy']);

// Report Lists
Route::get('/admin/report-categories-dropdown', [ReportListController::class, 'categories']);
Route::get('/admin/report-lists-dropdown', [ReportListController::class, 'dropdown']);
Route::get('/admin/report-lists', [ReportListController::class, 'index']);
Route::post('/admin/report-lists', [ReportListController::class, 'store']);
Route::put('/admin/report-lists/{id}', [ReportListController::class, 'update']);
Route::delete('/admin/report-lists/{id}', [ReportListController::class, 'destroy']);

// Report Details
Route::get('/admin/report-details', [App\Http\Controllers\Admin\ReportDetailController::class, 'index']);
Route::post('/admin/report-details', [App\Http\Controllers\Admin\ReportDetailController::class, 'store']);
Route::put('/admin/report-details/{id}', [App\Http\Controllers\Admin\ReportDetailController::class, 'update']);
Route::delete('/admin/report-details/{id}', [App\Http\Controllers\Admin\ReportDetailController::class, 'destroy']);
// Top Selling Reports
Route::get('/admin/top-selling-reports/search', [App\Http\Controllers\Admin\TopSellingReportController::class, 'search']);
Route::get('/admin/top-selling-reports', [App\Http\Controllers\Admin\TopSellingReportController::class, 'index']);
Route::post('/admin/top-selling-reports', [App\Http\Controllers\Admin\TopSellingReportController::class, 'store']);
Route::delete('/admin/top-selling-reports/{id}', [App\Http\Controllers\Admin\TopSellingReportController::class, 'destroy']);
// Blogs
Route::get('/admin/blogs', [App\Http\Controllers\Admin\BlogController::class, 'index']);
Route::post('/admin/blogs', [App\Http\Controllers\Admin\BlogController::class, 'store']);
Route::put('/admin/blogs/{id}', [App\Http\Controllers\Admin\BlogController::class, 'update']);
Route::delete('/admin/blogs/{id}', [App\Http\Controllers\Admin\BlogController::class, 'destroy']);
