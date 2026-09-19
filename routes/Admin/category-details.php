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
        $models = [
            \App\Models\ReportDetail::class,
            \App\Models\CaseStudyDetail::class,
            \App\Models\BlogDetail::class,
            \App\Models\PressReleaseDetail::class,
            \App\Models\ReportMethodology::class,
        ];
        $processed = [];
        foreach ($models as $modelClass) {
            $records = $modelClass::all();
            foreach ($records as $record) {
                $contentStr = json_encode($record->toArray());
                if (str_contains($contentStr, 'data:image')) {
                    $record->save();
                    $processed[] = [
                        'type' => class_basename($modelClass),
                        'id' => $record->id,
                        'title' => $record->title ?? ($record->page_main_title ?? 'ID ' . $record->id),
                    ];
                }
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Processed ' . count($processed) . ' records with base64 images.',
            'processed_records' => $processed,
        ]);
    })->name('report_details.fix_base64');
});
