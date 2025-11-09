<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CashierController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\InformationController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/information', [HomeController::class, 'information'])->name('information');

// Admin Routes - SEMUA BISA AKSES DULU TANPA MIDDLEWARE
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products - TANPA MIDDLEWARE DULU
    Route::resource('products', ProductController::class);
    
    // Cashier - TANPA MIDDLEWARE DULU
    Route::get('/cashier', [CashierController::class, 'index'])->name('cashier.index');
    Route::post('/cashier', [CashierController::class, 'store'])->name('cashier.store');
    Route::get('/cashier/{transaction}', [CashierController::class, 'show'])->name('cashier.show');
    Route::get('/cashier/{transaction}/print', [CashierController::class, 'print'])->name('cashier.print');
    
    // Reports - TANPA MIDDLEWARE DULU
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    
    // Information - TANPA MIDDLEWARE DULU
    Route::get('/information', [InformationController::class, 'index'])->name('information.index');
    Route::get('/information/{information}/edit', [InformationController::class, 'edit'])->name('information.edit');
    Route::put('/information/{information}', [InformationController::class, 'update'])->name('information.update');
});

require __DIR__.'/auth.php';