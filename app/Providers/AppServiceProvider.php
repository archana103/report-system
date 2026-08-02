<?php

namespace App\Providers;

use App\Models\ReportCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.header', function ($view) {
            $view->with('headerCategories', ReportCategory::query()
                ->select('name', 'slug_url')
                ->where('status', 'Active')
                ->orderBy('name')
                ->get());
        });
    }
}
