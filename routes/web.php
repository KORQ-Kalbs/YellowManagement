<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ikanController;

Route::view('/', 'welcome');

Route::middleware('auth')->group(function () {
    
Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

Route::view('profile', 'profile')
    ->name('profile');
});


require __DIR__.'/auth.php';
