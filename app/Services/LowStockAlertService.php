<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class LowStockAlertService
{
    public function threshold(): int
    {
        return Product::LOW_STOCK_THRESHOLD;
    }

    public function products(): Collection
    {
        return Product::query()
            ->select('id', 'nama_produk', 'kategori_id', 'stok', 'status')
            ->with('kategori:id,nama_kategori')
            ->where('stok', '<=', $this->threshold())
            ->orderBy('stok')
            ->orderBy('nama_produk')
            ->get();
    }

    public function isDismissedForToday(?int $userId = null): bool
    {
        $userId ??= auth()->id();

        if (!$userId) {
            return false;
        }

        return Cache::has($this->dismissKey($userId));
    }

    public function dismissForToday(?int $userId = null): void
    {
        $userId ??= auth()->id();

        if (!$userId) {
            return;
        }

        Cache::put($this->dismissKey($userId), true, now()->endOfDay());
    }

    private function dismissKey(int $userId): string
    {
        return 'low_stock_alert_dismissed:' . $userId . ':' . now()->toDateString();
    }
}