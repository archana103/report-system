<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReportDetailController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/category-details', [ReportDetailController::class, 'index'])->name('report_details.index');
    Route::get('/category-details/create', [ReportDetailController::class, 'create'])->name('report_details.create');
    Route::post('/category-details', [ReportDetailController::class, 'store'])->name('report_details.store');
    Route::get('/category-details/{id}/edit', [ReportDetailController::class, 'edit'])->name('report_details.edit');
    Route::put('/category-details/{id}', [ReportDetailController::class, 'update'])->name('report_details.update');
    Route::delete('/category-details/{id}', [ReportDetailController::class, 'destroy'])->name('report_details.destroy');
    Route::post('/category-details/upload-image', [ReportDetailController::class, 'uploadEditorImage'])->name('report_details.upload_image');
    Route::post('/editor/upload-image', [ReportDetailController::class, 'uploadEditorImage']);
    Route::get('/category-details/fix-base64-images', function () {
        $reports = \App\Models\ReportDetail::all();
        $processed = [];
        foreach ($reports as $report) {
            $hasB64 = str_contains($report->description ?? '', 'data:image') ||
                      str_contains($report->detail_description ?? '', 'data:image') ||
                      str_contains($report->table_of_contents ?? '', 'data:image');
            if ($hasB64) {
                $report->save();
                $processed[] = [
                    'id' => $report->id,
                    'title' => $report->title,
                    'slug' => $report->slug_url,
                ];
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Processed ' . count($processed) . ' reports with base64 images.',
            'processed_reports' => $processed,
        ]);
    })->name('report_details.fix_base64');
});
