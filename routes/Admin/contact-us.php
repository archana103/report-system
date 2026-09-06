<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactUsController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact_us.index');
});
