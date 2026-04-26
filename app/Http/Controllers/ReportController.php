<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Models\Transaksi;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

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
        $view = $isKasir ? 'kasir.laporan.index-laporan' : 'admin.laporan.index-laporan';
        
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
        
        // Optimize: Use direct join instead of subquery for better performance
        $query = Product::select('products.id', 'products.nama_produk', 'products.kategori_id', 'products.harga')
            ->selectRaw('SUM(detail_transaksis.jumlah) as sold_count')
            ->join('detail_transaksis', 'products.id', '=', 'detail_transaksis.product_id')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->whereBetween('transaksis.tanggal_transaksi', [$startDate, $endDate])
            ->where('transaksis.status', 'completed');
        
        if ($isKasir) {
            $query->where('transaksis.user_id', $userId);
        }
        
        return $query->with('kategori:id,nama_kategori')
            ->groupBy('products.id', 'products.nama_produk', 'products.kategori_id', 'products.harga')
            ->orderBy('sold_count', 'desc')
            ->limit(5)
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

    public function exportExcel(Request $request)
    {
        $period       = $request->get('period', 'day');
        $date         = $request->get('date', now()->format('Y-m-d'));
        $selectedDate = Carbon::parse($date);
        $isKasir      = auth()->user()->role === 'kasir';
        $userId       = auth()->id();

        $filename = 'laporan-transaksi-' . $period . '-' . $selectedDate->format('Y-m-d') . '.xlsx';

        return Excel::download(
            new TransaksiExport($period, $selectedDate, $isKasir, $userId),
            $filename
        );
    }

    public function exportPdf(Request $request)
    {
        $period       = $request->get('period', 'day');
        $date         = $request->get('date', now()->format('Y-m-d'));
        $selectedDate = Carbon::parse($date);
        $isKasir      = auth()->user()->role === 'kasir';
        $userId       = auth()->id();

        [$startDate, $endDate] = match ($period) {
            'week'  => [$selectedDate->copy()->startOfWeek(), $selectedDate->copy()->endOfWeek()],
            'month' => [$selectedDate->copy()->startOfMonth(), $selectedDate->copy()->endOfMonth()],
            default => [$selectedDate->copy()->startOfDay(), $selectedDate->copy()->endOfDay()],
        };

        $transaksis = Transaksi::with(['details.product', 'user', 'pembayaran', 'discountEvent'])
            ->whereBetween('tanggal_transaksi', [$startDate, $endDate])
            ->where('status', 'completed')
            ->when($isKasir, fn($q) => $q->where('user_id', $userId))
            ->orderBy('tanggal_transaksi')
            ->get();

        $pdf = Pdf::loadView('exports.laporan-pdf', compact(
            'transaksis', 'period', 'selectedDate', 'isKasir'
        ))->setPaper('a4', 'landscape');

        $filename = 'laporan-transaksi-' . $period . '-' . $selectedDate->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
