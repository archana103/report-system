<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('reports:fix-base64', function () {
    $this->info('Scanning all detail models for base64 images...');
    
    $count = 0;
    $models = [
        \App\Models\ReportDetail::class,
        \App\Models\CaseStudyDetail::class,
        \App\Models\BlogDetail::class,
        \App\Models\PressReleaseDetail::class,
        \App\Models\ReportMethodology::class,
    ];

    foreach ($models as $modelClass) {
        $records = $modelClass::all();
        foreach ($records as $record) {
            $contentStr = json_encode($record->toArray());
            if (str_contains($contentStr, 'data:image')) {
                $this->info("Processing " . class_basename($modelClass) . " ID {$record->id}");
                $record->save();
                $count++;
            }
        }
    }
    
    $this->info("Done! Processed {$count} records.");
})->purpose('Find all base64 images in all detail models and upload them to S3');

