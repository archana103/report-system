<?php

use App\Http\Controllers\Frontend\PressReleaseController;

Route::get('/press-releases', [PressReleaseController::class, 'index'])->name('pr.index');
Route::get('/press-release/{slug}', [PressReleaseController::class, 'show'])->name('pr.show');