<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PricingController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/pricings', [PricingController::class, 'index']);
    Route::post('/pricings', [PricingController::class, 'store']);
    Route::put('/pricings/{id}', [PricingController::class, 'update']);
    Route::delete('/pricings/{id}', [PricingController::class, 'destroy']);

    Route::get('/pricing-setup', [PricingController::class, 'index'])->name('pricing.index');
    Route::post('/pricing-setup', [PricingController::class, 'store'])->name('pricing.store');
    Route::put('/pricing-setup/{id}', [PricingController::class, 'update'])->name('pricing.update');
    Route::delete('/pricing-setup/{id}', [PricingController::class, 'destroy'])->name('pricing.destroy');
});
