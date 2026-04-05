<?php
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ReportCategoryController;

Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/report-categories', [ReportCategoryController::class, 'store']);
