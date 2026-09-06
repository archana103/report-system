<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheKeyTrait
{
    /**
     * Generate a localized cache key using the global version.
     *
     * @param string $prefix
     * @param mixed ...$suffixParams
     * @return string
     */
    protected function generateCacheKey(string $prefix, ...$suffixParams)
    {
        //get cache category to all page
        $version = Cache::get('userview_cache_version', 1);
        
        $key = sprintf('%s_v%s', $prefix, $version);
        
        foreach ($suffixParams as $param) {
            $key .= sprintf('_c%s', md5((string)$param));
        }
        
        return $key;
    }
}
