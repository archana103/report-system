<?php 

use App\Http\Controllers\Frontend\ServicesController;
Route::get('/services', [ServicesController::class, 'index'])->name('services');
?>