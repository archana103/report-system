<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportDetailController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/category-details', [ReportDetailController::class, 'index'])->name('report_details.index');
    Route::get('/category-details/create', [ReportDetailController::class, 'create'])->name('report_details.create');
    Route::post('/category-details', [ReportDetailController::class, 'store'])->name('report_details.store');
    Route::get('/category-details/{id}/edit', [ReportDetailController::class, 'edit'])->name('report_details.edit');
    Route::put('/category-details/{id}', [ReportDetailController::class, 'update'])->name('report_details.update');
    Route::delete('/category-details/{id}', [ReportDetailController::class, 'destroy'])->name('report_details.destroy');
    Route::post('/category-details/upload-image', [ReportDetailController::class, 'uploadEditorImage'])->name('report_details.upload_image');
    Route::post('/editor/upload-image', [ReportDetailController::class, 'uploadEditorImage']);
});
