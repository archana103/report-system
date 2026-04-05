<?php
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\ReportCategoryController;

Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/report-categories', [ReportCategoryController::class, 'index']);
Route::post('/admin/report-categories', [ReportCategoryController::class, 'store']);
Route::put('/admin/report-categories/{id}', [ReportCategoryController::class, 'update']);
Route::delete('/admin/report-categories/{id}', [ReportCategoryController::class, 'destroy']);
