<?php

namespace App\Services;

use App\Models\ReportCategory;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    /**
     * Get active report categories for dropdowns and sidebars.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDropdownCategories()
    {
        $version = Cache::get('userview_cache_version', 1);
        $key = 'categories_dropdown_v' . $version;
        
        return Cache::remember($key, 60 * 60 * 24, function () {
            return ReportCategory::select('id', 'name', 'slug_url')
                ->where('status', 'Active')
                ->orderBy('name')
                ->get();
        });
    }
}
