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

        // Get last 7 days sales data for chart
        $salesData = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $labels[] = $date->format('D');
            $salesData[] = Transaksi::where('user_id', $userId)
                ->whereDate('tanggal_transaksi', $date)
                ->where('status', 'completed')
                ->sum('total_harga');
        }

        $data = [
            'transaksi_hari_ini' => Transaksi::where('user_id', $userId)
                ->whereDate('tanggal_transaksi', $today)
                ->count(),
                
            'pendapatan_hari_ini' => Transaksi::where('user_id', $userId)
                ->whereDate('tanggal_transaksi', $today)
                ->where('status', 'completed')
                ->sum('total_harga'),
                
            'transaksi_terbaru' => Transaksi::where('user_id', $userId)
                ->with(['details.product', 'pembayaran'])
                ->latest('tanggal_transaksi')
                ->take(5)
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
        $products = Product::with('kategori')
            ->where('status', 'active')
            ->where('stok', '>', 0)
            ->get();

        $kategoris = Kategori::withCount('products')->get();

        return view('kasir.POS', compact('products', 'kategoris'));
    }
}