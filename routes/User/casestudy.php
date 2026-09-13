<?php

use App\Http\Controllers\Frontend\CaseStudyController;

Route::get('/case-studies', [CaseStudyController::class, 'index'])->name('cs.index');
Route::get('/case-study/{slug}', [CaseStudyController::class, 'show'])->name('cs.show');
