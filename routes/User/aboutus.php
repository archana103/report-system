<?php

use App\Http\Controllers\Frontend\AboutUsController;
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about');
?>