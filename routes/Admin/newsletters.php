<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsletterController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/newsletters', [NewsletterController::class, 'index'])->name('newsletters.index');
    Route::delete('/newsletters/{id}', [NewsletterController::class, 'destroy'])->name('newsletters.destroy');
});
