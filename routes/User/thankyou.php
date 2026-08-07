<?php

use App\Http\Controllers\Frontend\ThankYouController;
Route::get('/thank-you', [ThankYouController::class, 'index'])->name('thank-you');
?>