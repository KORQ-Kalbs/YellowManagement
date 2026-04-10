<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\View\View;

class KasirController extends Controller
{
    /**
     * Tampilkan dashboard kasir
     */
    public function dashboard(): View
    {
        $today = today();
        $userId = auth()->id();

        // Optimize: Single query for last 7 days sales data using GROUP BY
        $salesDataRaw = Transaksi::selectRaw('DATE(tanggal_transaksi) as date, SUM(total_harga) as total')
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->whereBetween('tanggal_transaksi', [today()->subDays(6)->startOfDay(), today()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        // Build chart data
        $salesData = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $labels[] = $date->format('D');
            $salesData[] = $salesDataRaw[$date->format('Y-m-d')] ?? 0;
        }

        // Optimize: Combine today's stats in single query
        $todayStats = Transaksi::selectRaw('
                COUNT(*) as transaksi_count,
                SUM(CASE WHEN status = "completed" THEN total_harga ELSE 0 END) as pendapatan
            ')
            ->where('user_id', $userId)
            ->whereDate('tanggal_transaksi', $today)
            ->first();

        $data = [
            'transaksi_hari_ini' => $todayStats->transaksi_count ?? 0,
            'pendapatan_hari_ini' => $todayStats->pendapatan ?? 0,
                
            'transaksi_terbaru' => Transaksi::select('id', 'no_invoice', 'tanggal_transaksi', 'total_harga', 'status', 'user_id')
                ->where('user_id', $userId)
                ->with([
                    'details:id,transaksi_id,product_id,jumlah,subtotal',
                    'details.product:id,nama_produk,harga',
                    'pembayaran:id,transaksi_id,metode_pembayaran,jumlah_pembayaran'
                ])
                ->latest('tanggal_transaksi')
                ->limit(5)
                ->get(),
            
            'salesData' => $salesData,
            'labels' => $labels,
        ];

        return view('kasir.dashboard', $data);
    }

    /**
     * Tampilkan halaman POS (Point of Sale)
     */
    public function pos(): View
    {
        // Optimize: Select only needed columns and use cache for categories
        $products = Product::select('id', 'nama_produk', 'kategori_id', 'harga', 'stok', 'status')
            ->with(['kategori:id,nama_kategori', 'variants'])
            ->where('status', 'active')
            ->where('stok', '>', 0)
            ->orderBy('nama_produk')
            ->get();

        // Use cached categories from AppServiceProvider
        $kategoris = cache()->remember('kategoris_with_count', 3600, function () {
            return Kategori::select('id', 'nama_kategori')
                ->withCount('products')
                ->orderBy('nama_kategori')
                ->get();
        });

        // Get currently active discount events
        $discountEvents = \App\Models\DiscountEvent::active()->get();

        return view('kasir.POS', compact('products', 'kategoris', 'discountEvents'));
    }
}