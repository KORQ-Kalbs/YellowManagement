<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Kategori;

class CacheService
{
    /**
     * Cache duration in seconds (1 hour)
     */
    const CACHE_DURATION = 3600;

    /**
     * Get all categories with caching
     */
    public static function getKategoris()
    {
        return Cache::remember('kategoris_all', self::CACHE_DURATION, function () {
            return Kategori::select('id', 'nama_kategori')
                ->orderBy('nama_kategori')
                ->get();
        });
    }

    /**
     * Get categories with product count
     */
    public static function getKategorisWithCount()
    {
        return Cache::remember('kategoris_with_count', self::CACHE_DURATION, function () {
            return Kategori::select('id', 'nama_kategori', 'deskripsi')
                ->withCount('products')
                ->orderBy('nama_kategori')
                ->get();
        });
    }

    /**
     * Clear all category caches
     */
    public static function clearKategoriCache()
    {
        Cache::forget('kategoris_all');
        Cache::forget('kategoris_with_count');
    }

    /**
     * Clear all application caches
     */
    public static function clearAllCache()
    {
        Cache::flush();
    }
}
