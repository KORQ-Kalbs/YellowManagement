<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $isKasir = auth()->user()->role === 'kasir';
        
        // Get period from request (default: day)
        $period = $request->get('period', 'day');
        $date = $request->get('date', now()->format('Y-m-d'));
        
        // Parse the date
        $selectedDate = Carbon::parse($date);
        
        // Get sales data based on period
        [$salesData, $labels] = $this->getSalesData($period, $selectedDate, $isKasir, $userId);
        
        // Get summary statistics
        $stats = $this->getStatistics($period, $selectedDate, $isKasir, $userId);
        
        // Get top products
        $topProducts = $this->getTopProducts($period, $selectedDate, $isKasir, $userId);
        
        // Use different views for admin and kasir
        $view = $isKasir ? 'kasir.laporan.index' : 'admin.laporan.index';
        
        return view($view, compact(
            'salesData',
            'labels',
            'stats',
            'topProducts',
            'period',
            'selectedDate'
        ));
    }
    
    private function getSalesData($period, $selectedDate, $isKasir, $userId)
    {
        $salesData = [];
        $labels = [];
        
        switch ($period) {
            case 'day':
                // Last 7 days
                for ($i = 6; $i >= 0; $i--) {
                    $date = $selectedDate->copy()->subDays($i);
                    $labels[] = $date->format('D');
                    $salesData[] = $this->getRevenue($date->startOfDay(), $date->endOfDay(), $isKasir, $userId);
                }
                break;
                
            case 'week':
                // Last 8 weeks
                for ($i = 7; $i >= 0; $i--) {
                    $weekStart = $selectedDate->copy()->subWeeks($i)->startOfWeek();
                    $weekEnd = $weekStart->copy()->endOfWeek();
                    $labels[] = 'W' . $weekStart->weekOfYear;
                    $salesData[] = $this->getRevenue($weekStart, $weekEnd, $isKasir, $userId);
                }
                break;
                
            case 'month':
                // Last 12 months
                for ($i = 11; $i >= 0; $i--) {
                    $monthStart = $selectedDate->copy()->subMonths($i)->startOfMonth();
                    $monthEnd = $monthStart->copy()->endOfMonth();
                    $labels[] = $monthStart->format('M');
                    $salesData[] = $this->getRevenue($monthStart, $monthEnd, $isKasir, $userId);
                }
                break;
        }
        
        return [$salesData, $labels];
    }
    
    private function getRevenue($startDate, $endDate, $isKasir, $userId)
    {
        $query = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'completed');
        
        if ($isKasir) {
            $query->where('user_id', $userId);
        }
        
        return $query->sum('total_harga');
    }
    
    private function getStatistics($period, $selectedDate, $isKasir, $userId)
    {
        // Determine date range based on period
        switch ($period) {
            case 'day':
                $startDate = $selectedDate->copy()->startOfDay();
                $endDate = $selectedDate->copy()->endOfDay();
                break;
            case 'week':
                $startDate = $selectedDate->copy()->startOfWeek();
                $endDate = $selectedDate->copy()->endOfWeek();
                break;
            case 'month':
                $startDate = $selectedDate->copy()->startOfMonth();
                $endDate = $selectedDate->copy()->endOfMonth();
                break;
            default:
                $startDate = $selectedDate->copy()->startOfDay();
                $endDate = $selectedDate->copy()->endOfDay();
        }
        
        $transactionQuery = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate]);
        $revenueQuery = Transaksi::whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'completed');
        
        if ($isKasir) {
            $transactionQuery->where('user_id', $userId);
            $revenueQuery->where('user_id', $userId);
        }
        
        return [
            'totalTransactions' => $transactionQuery->count(),
            'totalRevenue' => $revenueQuery->sum('total_harga'),
            'dailyRevenue' => Transaksi::whereDate('tanggal_transaksi', now())
                ->where('status', 'completed')
                ->when($isKasir, fn($q) => $q->where('user_id', $userId))
                ->sum('total_harga'),
        ];
    }
    
    private function getTopProducts($period, $selectedDate, $isKasir, $userId)
    {
        // Determine date range
        switch ($period) {
            case 'day':
                $startDate = $selectedDate->copy()->startOfDay();
                $endDate = $selectedDate->copy()->endOfDay();
                break;
            case 'week':
                $startDate = $selectedDate->copy()->startOfWeek();
                $endDate = $selectedDate->copy()->endOfWeek();
                break;
            case 'month':
                $startDate = $selectedDate->copy()->startOfMonth();
                $endDate = $selectedDate->copy()->endOfMonth();
                break;
            default:
                $startDate = $selectedDate->copy()->subDays(30);
                $endDate = $selectedDate->copy();
        }
        
        return Product::with('kategori')
            ->withCount(['detailTransaksis as sold_count' => function($query) use ($isKasir, $userId, $startDate, $endDate) {
                $query->select(DB::raw('SUM(jumlah)'))
                    ->whereHas('transaksi', function($q) use ($isKasir, $userId, $startDate, $endDate) {
                        $q->whereBetween('tanggal_transaksi', [$startDate, $endDate])
                          ->where('status', 'completed');
                        if ($isKasir) {
                            $q->where('user_id', $userId);
                        }
                    });
            }])
            ->having('sold_count', '>', 0)
            ->orderBy('sold_count', 'desc')
            ->take(5)
            ->get();
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
