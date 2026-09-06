<?php 

use App\Http\Controllers\Frontend\ServicesController;
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/qualitative-services', [ServicesController::class, 'qualitative'])->name('qualitative.services');
?>