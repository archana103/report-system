<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PurchaseController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::delete('/purchases/{id}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
});
