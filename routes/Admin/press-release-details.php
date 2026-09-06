<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PressReleaseDetailController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/press-release-details', [PressReleaseDetailController::class, 'index'])->name('press_release_details.index');
    Route::get('/press-release-details/{id}/edit', [PressReleaseDetailController::class, 'edit'])->name('press_release_details.edit');
    Route::put('/press-release-details/{id}', [PressReleaseDetailController::class, 'update'])->name('press_release_details.update');
    Route::delete('/press-release-details/{id}', [PressReleaseDetailController::class, 'destroy'])->name('press_release_details.destroy');
});
