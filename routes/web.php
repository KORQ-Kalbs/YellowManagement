<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProductImageController;

// Public route
Route::view('/', 'welcome');
Route::view('/menu', 'menu')->name('menu');
Route::get('/cart', function () {
    return view('cart');
});
// Auth routes
require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware('auth')->group(function () {
    
    // Dashboard - redirect based on role
    Route::get('dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('kasir.dashboard');
    })->name('dashboard');
    
    // Profile
    Route::view('profile', 'profile')->name('profile');
});

// ==============================================
// ADMIN ROUTES
// ==============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', function () {
        // Get last 7 days sales data for chart
        $salesData = [];
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $labels[] = $date->format('D');
            $salesData[] = \App\Models\Transaksi::whereDate('tanggal_transaksi', $date)
                ->where('status', 'completed')
                ->sum('total_harga');
        }
        
        $totalProdukTerjual = \App\Models\DetailTransaksi::whereHas('transaksi', function($q) {
            $q->where('status', 'completed');
        })->sum('jumlah');

        $totalPendapatan = \App\Models\Transaksi::where('status', 'completed')->sum('total_harga');
        $pengeluaran = \App\Models\Expense::sum('amount');
        $pendapatanBersih = $totalPendapatan - $pengeluaran;
        
        return view('admin.dashboard', compact('salesData', 'labels', 'totalProdukTerjual', 'totalPendapatan', 'pengeluaran', 'pendapatanBersih'));
    })->name('dashboard');
    
    // Product Management (Produk)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::resource('products', ProductController::class)->except(['index']);

    // Image Library (Public Images)
    Route::get('/img-product', [ProductImageController::class, 'index'])->name('img-product.index');
    Route::post('/img-product', [ProductImageController::class, 'store'])->name('img-product.store');
    Route::put('/img-product/{productImage}', [ProductImageController::class, 'update'])->name('img-product.update');
    Route::delete('/img-product/{productImage}', [ProductImageController::class, 'destroy'])->name('img-product.destroy');
    
    // Kategori Management
    Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
    Route::resource('kategoris', KategoriController::class)->except(['index']);
    
    // Discount Event Management
    Route::resource('event-diskon', \App\Http\Controllers\DiscountEventController::class);
    
    // Expense Management (Pengeluaran)
    Route::resource('expenses', \App\Http\Controllers\ExpenseController::class)->except(['show']);
    Route::post('/expense-categories', [\App\Http\Controllers\ExpenseController::class, 'storeCategory'])->name('expense-categories.store');
    Route::delete('/expense-categories/{category}', [\App\Http\Controllers\ExpenseController::class, 'destroyCategory'])->name('expense-categories.destroy');
    // Kasir Management
    Route::prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::put('/{kasir}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::delete('/{kasir}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
    });
    
    // Units Management (Satuan Produk)
    Route::get('/units', function () {
        return view('admin.satuan_produk.index');
    })->name('units.index');
    
    // Settings
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');
    
    // View All Transactions (Admin can see all)
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/receipt-pdf', [TransaksiController::class, 'exportReceiptPdf'])->name('transaksi.receipt.pdf');
    Route::get('/transaksi/{id}/receipt-excel', [TransaksiController::class, 'exportReceiptExcel'])->name('transaksi.receipt.excel');
    Route::patch('/transaksi/{id}/batalkan', [TransaksiController::class, 'batalkan'])->name('transaksi.batalkan');
    Route::patch('/transaksi/{id}/selesai', [TransaksiController::class, 'selesai'])->name('transaksi.selesai');
    Route::patch('/transaksi/{id}/suspend', [TransaksiController::class, 'suspend'])->name('transaksi.suspend');
    
    // Reports (Laporan)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export-excel', [ReportController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/history', function () {
            return view('admin.laporan.history');
        })->name('history');
    });
    
    // POS for Admin (Testing)
    Route::get('/pos', [KasirController::class, 'pos'])->name('pos');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
});

// ==============================================
// KASIR ROUTES
// ==============================================
Route::middleware(['auth', 'role:kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    
    // Kasir Dashboard
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('dashboard');
    
    // POS (Point of Sale)
    Route::get('/pos', [KasirController::class, 'pos'])->name('pos');
    
    // Create Transaction
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

    // Reports (Laporan)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export-excel', [ReportController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/kasir', [ReportController::class, 'kasirReport'])->name('kasir');
    });
    
    // View Own Transactions
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{id}/receipt-pdf', [TransaksiController::class, 'exportReceiptPdf'])->name('transaksi.receipt.pdf');
    Route::get('/transaksi/{id}/receipt-excel', [TransaksiController::class, 'exportReceiptExcel'])->name('transaksi.receipt.excel');
    Route::patch('/transaksi/{id}/batalkan', [TransaksiController::class, 'batalkan'])->name('transaksi.batalkan');
    Route::patch('/transaksi/{id}/selesai', [TransaksiController::class, 'selesai'])->name('transaksi.selesai');
    Route::patch('/transaksi/{id}/suspend', [TransaksiController::class, 'suspend'])->name('transaksi.suspend');
});