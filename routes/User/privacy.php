<?php 

use App\Http\Controllers\Frontend\PrivacyPolicyController;


Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy');