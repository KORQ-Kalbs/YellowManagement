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
    
    // Product Management (Produk)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::resource('products', ProductController::class)->except(['index']);
    
    // Kategori Management
    Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index');
    Route::resource('kategoris', KategoriController::class)->except(['index']);
    
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
    Route::patch('/transaksi/{id}/batalkan', [TransaksiController::class, 'batalkan'])->name('transaksi.batalkan');
    
    // Reports (Laporan)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
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

    // Reports (Laporan)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/kasir', [ReportController::class, 'kasirReport'])->name('kasir');
    });
    
    // View Own Transactions
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
});