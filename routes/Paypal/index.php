<?php
use App\Http\Controllers\Paypal\PaypalController;

Route::post('/api/paypal/create-order', [PaypalController::class, 'createOrder']);
Route::post('/api/paypal/capture-order/{id}', [PaypalController::class, 'captureOrder']);

