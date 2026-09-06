<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportListController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/category-list', [ReportListController::class, 'index'])->name('reports.index');
    Route::get('/category-list/create', [ReportListController::class, 'create'])->name('reports.create');
    Route::post('/category-list', [ReportListController::class, 'store'])->name('reports.store');
    Route::get('/category-list/{id}/edit', [ReportListController::class, 'edit'])->name('reports.edit');
    Route::put('/category-list/{id}', [ReportListController::class, 'update'])->name('reports.update');
    Route::delete('/category-list/{id}', [ReportListController::class, 'destroy'])->name('reports.destroy');
});
