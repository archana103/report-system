<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogDetailController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/blog-details', [BlogDetailController::class, 'index'])->name('blog_details.index');
    Route::get('/blog-details/{id}/edit', [BlogDetailController::class, 'edit'])->name('blog_details.edit');
    Route::put('/blog-details/{id}', [BlogDetailController::class, 'update'])->name('blog_details.update');
    Route::delete('/blog-details/{id}', [BlogDetailController::class, 'destroy'])->name('blog_details.destroy');
});