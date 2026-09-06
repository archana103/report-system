<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogRequestController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/blog-requests', [BlogRequestController::class, 'index'])->name('blog_requests.index');
    Route::delete('/blog-requests/{id}', [BlogRequestController::class, 'destroy'])->name('blog_requests.destroy');
});
