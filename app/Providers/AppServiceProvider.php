<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use App\Models\Kategori;

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
        // Cache categories globally for 1 hour (rarely change)
        View::composer('*', function ($view) {
            if (!$view->offsetExists('cachedKategoris')) {
                $kategoris = Cache::remember('kategoris_all', 3600, function () {
                    return Kategori::select('id', 'nama_kategori')
                        ->orderBy('nama_kategori')
                        ->get();
                });
                $view->with('cachedKategoris', $kategoris);
            }
        });
    }
}
