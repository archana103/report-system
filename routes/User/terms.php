<?php 

use App\Http\Controllers\Frontend\TermsController;


Route::get('/terms-and-conditions', [TermsController::class, 'index'])->name('terms');