<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = 0;
foreach (\App\Models\ReportDetail::all() as $rd) {
    if (preg_match('/[\r\n]/', $rd->title)) {
        $rd->title = preg_replace('/\s+/', ' ', trim($rd->title));
        $rd->save();
        $count++;
        echo "Fixed ReportDetail ID: {$rd->id}\n";
    }
}

foreach (\App\Models\ReportList::all() as $rl) {
    if (preg_match('/[\r\n]/', $rl->name)) {
        $rl->name = preg_replace('/\s+/', ' ', trim($rl->name));
        $rl->save();
        $count++;
        echo "Fixed ReportList ID: {$rl->id}\n";
    }
}

echo "Cleaned {$count} database records.\n";
