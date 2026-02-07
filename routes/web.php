<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembayaranController;

Route::view('/', 'welcome');

Route::middleware('auth')->group(function () {
    
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::view('profile', 'profile')
        ->name('profile');

    // Product routes
    Route::resource('products', ProductController::class);

    // Transaksi routes
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::patch('/{id}/selesai', [TransaksiController::class, 'selesai'])->name('transaksi.selesai');
        Route::patch('/{id}/batalkan', [TransaksiController::class, 'batalkan'])->name('transaksi.batalkan');
    });

    // Pembayaran routes
    Route::prefix('pembayaran')->group(function () {
        Route::post('/', [PembayaranController::class, 'store'])->name('pembayaran.store');
    });
});

require __DIR__.'/auth.php';
