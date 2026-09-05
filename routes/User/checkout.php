<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\CheckoutFrontendController;
use App\Http\Controllers\CheckoutController;

Route::get('/checkout/{slug}', [CheckoutFrontendController::class, 'checkout'])->name('checkout.index');
Route::get('/purchase/{slug}', [CheckoutFrontendController::class, 'purchase'])->name('checkout.purchase');
Route::post('/api/checkout/purchase', [CheckoutController::class, 'store'])->name('checkout.store');
