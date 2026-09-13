<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CaseStudyDetailController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/case-study-details', [CaseStudyDetailController::class, 'index'])->name('case_study_details.index');
    Route::get('/case-study-details/{id}/edit', [CaseStudyDetailController::class, 'edit'])->name('case_study_details.edit');
    Route::put('/case-study-details/{id}', [CaseStudyDetailController::class, 'update'])->name('case_study_details.update');
    Route::delete('/case-study-details/{id}', [CaseStudyDetailController::class, 'destroy'])->name('case_study_details.destroy');
});
