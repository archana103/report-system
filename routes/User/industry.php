<?php

use App\Http\Controllers\Frontend\IndustryController;

Route::get('/industry/{slug}', [IndustryController::class, 'show'])->name('industry.show');
