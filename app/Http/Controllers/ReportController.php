<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Get last 7 days sales data for chart
        $salesData = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $labels[] = $date->format('D');
            $salesData[] = Transaksi::whereDate('tanggal_transaksi', $date)
                ->where('status', 'completed')
                ->sum('total_harga');
        }

        $totalTransactions = Transaksi::count();
        $totalRevenue = Transaksi::where('status', 'completed')->sum('total_harga');
        $dailyRevenue = Transaksi::whereDate('tanggal_transaksi', today())
            ->where('status', 'completed')
            ->sum('total_harga');
        
        // Get top products with their sales count
        $topProducts = Product::with('kategori')
            ->withCount(['detailTransaksis as sold_count' => function($query) {
                $query->select(DB::raw('SUM(jumlah)'));
            }])
            ->orderBy('sold_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.laporan.index', compact(
            'totalTransactions', 
            'totalRevenue', 
            'dailyRevenue', 
            'topProducts',
            'salesData',
            'labels'
        ));
    }

    public function daily()
    {
        return $this->index();
    }

    public function monthly()
    {
        return $this->index();
    }

    public function products()
    {
        return $this->index();
    }
}
