<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TopSellingReportController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/top-selling-reports', [TopSellingReportController::class, 'index'])->name('top_selling_reports.index');
    Route::post('/top-selling-reports', [TopSellingReportController::class, 'store'])->name('top_selling_reports.store');
    Route::delete('/top-selling-reports/{id}', [TopSellingReportController::class, 'destroy'])->name('top_selling_reports.destroy');
});
