<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CheckoutFrontendController;

Route::get('/checkout/{slug}', [CheckoutFrontendController::class, 'checkout'])->name('checkout.index');
Route::get('/purchase/{slug}', [CheckoutFrontendController::class, 'purchase'])->name('checkout.purchase');
