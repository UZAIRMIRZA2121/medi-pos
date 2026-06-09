<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'role:store'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pos', [App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [App\Http\Controllers\PosController::class, 'checkout'])->name('pos.checkout');

    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    Route::resource('medicines', App\Http\Controllers\MedicineController::class);
    Route::resource('suppliers', App\Http\Controllers\SupplierController::class);
    Route::resource('customers', App\Http\Controllers\CustomerController::class);
    
    Route::get('/sales', [App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
    Route::get('/invoices', [App\Http\Controllers\SaleController::class, 'invoices'])->name('invoices.index');
    Route::get('/alerts', [App\Http\Controllers\AlertController::class, 'index'])->name('alerts.index');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // API endpoints for AJAX fetch
    Route::get('/api/categories', [App\Http\Controllers\CategoryController::class, 'apiIndex']);
    Route::get('/api/medicines', [App\Http\Controllers\MedicineController::class, 'apiIndex']);
    Route::get('/api/suppliers', [App\Http\Controllers\SupplierController::class, 'apiIndex']);
    Route::get('/api/customers', [App\Http\Controllers\CustomerController::class, 'apiIndex']);
    Route::get('/api/sales', [App\Http\Controllers\SaleController::class, 'apiIndex']);
});

require __DIR__.'/auth.php';
