<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\App\Models\ReportCategory::chunk(100, function ($categories) {
    foreach ($categories as $category) {
        $category->slug_url = \Illuminate\Support\Str::slug($category->name);
        $category->save();
    }
});
echo "Done.";
