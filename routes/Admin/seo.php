<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PageSeoController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/page-seo', [PageSeoController::class, 'index'])->name('page_seo.index');
    Route::post('/page-seo', [PageSeoController::class, 'store'])->name('page_seo.store');
    Route::put('/page-seo/{id}', [PageSeoController::class, 'update'])->name('page_seo.update');
    Route::delete('/page-seo/{id}', [PageSeoController::class, 'destroy'])->name('page_seo.destroy');
});
