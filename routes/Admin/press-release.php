<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PressReleaseController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/press-release', [PressReleaseController::class, 'index'])->name('press_releases.index');
    Route::get('/press-release/create', [PressReleaseController::class, 'create'])->name('press_releases.create');
    Route::post('/press-release', [PressReleaseController::class, 'store'])->name('press_releases.store');
    Route::get('/press-release/{id}/edit', [PressReleaseController::class, 'edit'])->name('press_releases.edit');
    Route::put('/press-release/{id}', [PressReleaseController::class, 'update'])->name('press_releases.update');
    Route::delete('/press-release/{id}', [PressReleaseController::class, 'destroy'])->name('press_releases.destroy');
});
