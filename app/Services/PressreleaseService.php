<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\PressRelease;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PressreleaseService
{
    /**
     * Get recent press releases.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function pressReleases()
    {
        $pressReleases = PressRelease::where('status', 'Active')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($pr) {
                return [
                    'title' => $pr->title,
                    'description' => Str::limit(strip_tags(html_entity_decode($pr->description)), 120),
                    'date' => $pr->created_at->format('F d, Y'),
                    'image' => $pr->thumbnail_image ?: ($pr->main_image ?: '/assets/images/press_release_default.png'),
                    'url' => $pr->url,
                ];
            });

        return response()->json($pressReleases);
    }
}
