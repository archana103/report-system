<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Base64ImageService
{
    /**
     * Process HTML content, find all base64 encoded images, upload them to S3 (editor disk),
     * and replace base64 data URIs with S3 CDN URLs (e.g. https://cdn.epignosisinsights.com/uploads/reports/...).
     *
     * @param string|null $html
     * @param string $prefix
     * @return string|null
     */
    public static function processHtmlBase64Images(?string $html, string $prefix = 'Report_Image'): ?string
    {
        if (empty($html) || !str_contains($html, 'data:image')) {
            return $html;
        }

        // Match src="data:image/{ext};base64,{data}" or src='data:image/{ext};base64,{data}'
        $pattern = '/src=["\'](data:image\/(png|jpeg|jpg|webp|gif|svg\+xml);base64,([A-Za-z0-9+\/=\s]+))["\']/i';

        return preg_replace_callback($pattern, function ($matches) use ($prefix) {
            $type = strtolower($matches[2]);
            $base64Data = $matches[3];

            // Map mime type to file extension
            $extension = match ($type) {
                'jpeg', 'jpg' => 'jpg',
                'webp' => 'webp',
                'gif' => 'gif',
                'svg+xml' => 'svg',
                default => 'png',
            };

            // Remove any whitespace inside base64 string
            $base64Data = preg_replace('/\s+/', '', $base64Data);
            $imageData = base64_decode($base64Data);

            if ($imageData === false) {
                Log::warning('Base64ImageService: Failed to decode base64 image');
                return $matches[0];
            }

            // Generate a clean SEO-friendly filename
            $cleanPrefix = Str::slug($prefix, '_') ?: 'Report_Image';
            if (strlen($cleanPrefix) > 60) {
                $cleanPrefix = substr($cleanPrefix, 0, 60);
            }
            
            $uniqueSuffix = uniqid() . '_' . Str::random(5);
            $filename = "{$cleanPrefix}_{$uniqueSuffix}.{$extension}";

            $path = "uploads/reports/{$filename}";

            try {
                // Upload image binary to S3 editor disk
                Storage::disk('editor')->put($path, $imageData);
                $url = Storage::disk('editor')->url($path);

                Log::info('Base64ImageService: Image uploaded to S3', ['url' => $url]);

                return 'src="' . $url . '"';
            } catch (\Exception $e) {
                Log::error('Base64ImageService S3 upload failed: ' . $e->getMessage());
                return $matches[0];
            }
        }, $html);
    }
}
