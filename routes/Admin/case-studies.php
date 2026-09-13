<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CaseStudyController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/case-studies', [CaseStudyController::class, 'index'])->name('case_studies.index');
    Route::get('/case-studies/create', [CaseStudyController::class, 'create'])->name('case_studies.create');
    Route::post('/case-studies', [CaseStudyController::class, 'store'])->name('case_studies.store');
    Route::get('/case-studies/{id}/edit', [CaseStudyController::class, 'edit'])->name('case_studies.edit');
    Route::put('/case-studies/{id}', [CaseStudyController::class, 'update'])->name('case_studies.update');
    Route::delete('/case-studies/{id}', [CaseStudyController::class, 'destroy'])->name('case_studies.destroy');
});
