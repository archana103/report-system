<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportCategoryController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/category-report', [ReportCategoryController::class, 'index'])->name('categories.index');
    Route::get('/category-report/create', [ReportCategoryController::class, 'create'])->name('categories.create');
    Route::post('/category-report', [ReportCategoryController::class, 'store'])->name('categories.store');
    Route::get('/category-report/{id}/edit', [ReportCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/category-report/{id}', [ReportCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/category-report/{id}', [ReportCategoryController::class, 'destroy'])->name('categories.destroy');
});
