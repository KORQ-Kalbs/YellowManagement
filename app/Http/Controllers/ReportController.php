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
        $totalTransactions = Transaksi::count();
        $totalRevenue = Transaksi::sum('grand_total');
        $dailyRevenue = Transaksi::whereDate('created_at', today())->sum('grand_total');
        $topProducts = Product::withCount('detailTransaksis as sold_count')->orderBy('sold_count', 'desc')->take(5)->get();

        return view('admin.reports.index', compact('totalTransactions', 'totalRevenue', 'dailyRevenue', 'topProducts'));
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
