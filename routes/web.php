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
    $packages = \App\Models\Package::where('id', '!=', 1)->where('status', 'active')->orderBy('sort_order', 'asc')->get();
    return view('welcome', compact('packages')); 
});

Route::get('/package/{slug}', function ($slug) {
    $package = \App\Models\Package::where('slug', $slug)->firstOrFail();
    return view('package', compact('package'));
})->name('package.show');

Route::get('/home', function () {
    if (auth()->check()) {
        if (auth()->user()->type === 'admin') {
            return redirect()->route('admin.users.index');
        }
        if (auth()->user()->type === 'seller') {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:store', 'subscription.active'])->group(function () {
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


    Route::get('/settings/print', [App\Http\Controllers\PrintSettingController::class, 'index'])->name('settings.print');
    Route::post('/settings/print', [App\Http\Controllers\PrintSettingController::class, 'store'])->name('settings.print.store');

    // Profile routes should probably be common
});

Route::middleware(['auth', 'subscription.active'])->group(function () {
    // Subscription Payment Routes
    Route::get('/subscription/payment', [App\Http\Controllers\SubscriptionController::class, 'payment'])->name('subscription.payment');
    Route::post('/subscription/payment', [App\Http\Controllers\SubscriptionController::class, 'uploadProof'])->name('subscription.payment.upload');

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

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::resource('packages', App\Http\Controllers\Admin\PackageController::class);
    Route::post('/users/{user}/toggle-subscription', [App\Http\Controllers\Admin\UserController::class, 'toggleSubscription'])->name('users.toggle-subscription');

    Route::get('/payments', [App\Http\Controllers\Admin\PaymentRequestController::class, 'index'])->name('payments.index');
    Route::post('/payments/{paymentRequest}/approve', [App\Http\Controllers\Admin\PaymentRequestController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{paymentRequest}/reject', [App\Http\Controllers\Admin\PaymentRequestController::class, 'reject'])->name('payments.reject');

});

// Seller Routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', function () {
        $packages = \App\Models\Package::where('status', 'active')->get();
        $stores = \App\Models\User::with(['package', 'subscriptions' => function($query) {
            $query->latest();
        }])->where('type', 'store')->where('parent_id', auth()->id())->get();
        
        return view('seller.dashboard', compact('packages', 'stores'));
    })->name('dashboard');
});

require __DIR__.'/auth.php';
