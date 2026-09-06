<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RequestFormController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/request-form', [RequestFormController::class, 'index'])->name('request_forms.index');
    Route::delete('/request-form/{id}', [RequestFormController::class, 'destroy'])->name('request_forms.destroy');
});
