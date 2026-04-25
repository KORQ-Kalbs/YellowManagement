<?php

namespace App\Providers;

use App\Models\DashboardSetting;
use App\Models\DiscountEvent;
use App\Models\Kategori;
use App\Models\Product;
use App\Services\LowStockAlertService;
use Illuminate\Support\Facades\Cache;
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

        View::composer([
            'admin.produk.index',
            'kasir.POS',
            'kasir.kelola.produk.index',
        ], function ($view) {
            $lowStockService = app(LowStockAlertService::class);

            $view->with([
                'lowStockProducts' => $lowStockService->products(),
                'lowStockAlertDismissed' => $lowStockService->isDismissedForToday(),
            ]);
        });

        View::composer(['welcome', 'menu', 'admin.dashboard'], function ($view) {
            $welcomeSettings = DashboardSetting::pageContent('welcome');
            $menuSettings = DashboardSetting::pageContent('menu');
            $activeDiscount = DiscountEvent::active()->latest('start_date')->first();

            $menuProducts = Product::query()
                ->select('id', 'nama_produk', 'kategori_id', 'harga', 'stok', 'status', 'gambar_produk')
                ->with([
                    'kategori:id,nama_kategori',
                    'variants:id,product_id,nama_variant,kode_variant,harga_tambahan,is_active,urutan',
                    'productImage:id,product_id,title,alt_text,original_name,file_name,file_path,mime_type,size',
                ])
                ->where('status', 'active')
                ->orderBy('kategori_id')
                ->orderBy('nama_produk')
                ->get();

            $menuCategories = $menuProducts
                ->groupBy(fn ($product) => $product->kategori?->nama_kategori ?? 'Lainnya')
                ->map(function ($items, $categoryName) {
                    return [
                        'name' => $categoryName,
                        'slug' => str()->slug($categoryName),
                        'items' => $items,
                    ];
                })
                ->values();

            $view->with([
                'welcomeSettings' => $welcomeSettings,
                'menuSettings' => $menuSettings,
                'activeDiscount' => $activeDiscount,
                'menuProducts' => $menuProducts,
                'menuCategories' => $menuCategories,
            ]);
        });
    }
}
