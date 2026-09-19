<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('reports:fix-base64', function () {
    $this->info('Scanning report details for base64 images...');
    $reports = \App\Models\ReportDetail::all();
    $count = 0;
    foreach ($reports as $report) {
        $hasB64 = str_contains($report->description ?? '', 'data:image') ||
                  str_contains($report->detail_description ?? '', 'data:image') ||
                  str_contains($report->table_of_contents ?? '', 'data:image');
        if ($hasB64) {
            $this->info("Processing report ID {$report->id}: {$report->title}");
            $report->save();
            $count++;
        }
    }
    $this->info("Done! Processed {$count} reports.");
})->purpose('Find all base64 images in report details and upload them to S3');

