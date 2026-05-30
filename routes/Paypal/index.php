<?php
use App\Http\Controllers\Paypal\PaypalController;

Route::post('/paypal/create-order', [PaypalController::class, 'createOrder']);
Route::post('/paypal/capture-order/{id}', [PaypalController::class, 'captureOrder']);
