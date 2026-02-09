<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\KategoriController;

// Public route
Route::view('/', 'welcome');

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
        return view('dashboard');
    })->name('dashboard');
    
    // Product Management
    Route::resource('products', ProductController::class);
    
    // Kategori Management
    Route::resource('kategoris', KategoriController::class);
    
    // Units Management
    Route::get('/units', function () {
        return view('admin.units.index');
    })->name('units.index');
    
    // Transactions Management
    Route::get('/transactions', function () {
        return view('admin.transactions.index');
    })->name('transactions.index');
    
    // Settings
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');
    
    // View All Transactions (Admin can see all)
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::patch('/transaksi/{id}/batalkan', [TransaksiController::class, 'batalkan'])->name('transaksi.batalkan');
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/daily', [ReportController::class, 'daily'])->name('daily');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
        Route::get('/products', [ReportController::class, 'products'])->name('products');
    });
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
    
    // View Own Transactions
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
});