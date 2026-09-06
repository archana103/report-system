<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportMethodologyController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/report-methodology-data', [ReportMethodologyController::class, 'index']);
    Route::post('/report-methodology-data', [ReportMethodologyController::class, 'store']);
    Route::get('/report-methodology', [ReportMethodologyController::class, 'index'])->name('methodology.index');
    Route::post('/report-methodology', [ReportMethodologyController::class, 'store'])->name('methodology.store');
});
