<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Cache\Repository as Cache;
use Symfony\Component\HttpFoundation\Response;

class CacheResponse
{
    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only cache GET requests
        if (!$request->isMethod('GET')) {
            return $next($request);
        }

        // Generate cache key
        $cacheKey = 'response_' . sha1($request->fullUrl());

        // Try to get response from cache
        try {
            if ($this->cache->has($cacheKey)) {
                $cachedResponse = $this->cache->get($cacheKey);
                if ($cachedResponse instanceof Response) {
                    return $cachedResponse;
                }
            }
        } catch (\Exception $e) {
            // If there's any issue with cache, proceed with normal request
            report($e);
        }

        // Get the response
        $response = $next($request);

        // Cache the response if successful
        if ($response->isSuccessful() && $response instanceof Response) {
            try {
                $this->cache->put($cacheKey, $response, now()->addSeconds(1));
            } catch (\Exception $e) {
                report($e);
            }
        }

        return $response;
    }
} 