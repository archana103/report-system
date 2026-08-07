<?php

use App\Http\Controllers\Frontend\ReportController;
use App\Http\Controllers\UserviewController;

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/report/{slug}', [ReportController::class, 'show'])->name('reports.show');
Route::post('/request-form', [UserviewController::class, 'storeRequestForm']);