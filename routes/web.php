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
use App\Http\Controllers\StaffAuthController;

// Staff Login
Route::get('staff/login', [StaffAuthController::class, 'showLoginForm'])->name('staff.login');
Route::post('staff/login', [StaffAuthController::class, 'login'])->name('staff.login.submit');



Route::get('/', function () {
    $packages = \App\Models\Package::where('id', '!=', 1)->where('status', 'active')->orderBy('sort_order', 'asc')->get();
    return view('welcome', compact('packages')); 
});

Route::get('/package/{slug}', function ($slug) {
    $package = \App\Models\Package::where('slug', $slug)->firstOrFail();
    return view('package', compact('package'));
})->name('package.show');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

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

Route::middleware(['auth', 'role:store,cashier', 'subscription.active'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('privilege:dashboard');
    Route::get('/pos', [App\Http\Controllers\PosController::class, 'index'])->name('pos.index')->middleware('privilege:pos');
    Route::post('/pos/checkout', [App\Http\Controllers\PosController::class, 'checkout'])->name('pos.checkout')->middleware('privilege:pos');

    Route::resource('expenses', App\Http\Controllers\ExpenseController::class)->except(['create', 'show', 'edit'])->middleware('privilege:expenses');
    Route::get('/sales', [App\Http\Controllers\SaleController::class, 'index'])->name('sales.index')->middleware('privilege:sales_history');
    Route::get('/invoices', [App\Http\Controllers\SaleController::class, 'invoices'])->name('invoices.index')->middleware('privilege:invoices');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit')->middleware('privilege:profile');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('privilege:profile');
});

Route::middleware(['auth', 'role:store', 'subscription.active'])->group(function () {
    Route::resource('categories', App\Http\Controllers\CategoryController::class)->middleware('privilege:categories');
    Route::resource('medicines', App\Http\Controllers\MedicineController::class)->middleware('privilege:medicines');
    Route::resource('suppliers', App\Http\Controllers\SupplierController::class)->middleware('privilege:suppliers');
    Route::resource('customers', App\Http\Controllers\CustomerController::class)->middleware('privilege:customers');
    Route::resource('staff', App\Http\Controllers\StaffController::class)->middleware('privilege:staff');
    
    Route::get('/alerts', [App\Http\Controllers\AlertController::class, 'index'])->name('alerts.index')->middleware('privilege:alerts');
    Route::get('/purchase-orders', [App\Http\Controllers\PurchaseOrderController::class, 'index'])->name('purchase_orders.index')->middleware('privilege:purchase_orders');
    Route::post('/purchase-orders', [App\Http\Controllers\PurchaseOrderController::class, 'store'])->name('purchase_orders.store')->middleware('privilege:purchase_orders');
    Route::get('/purchase-orders/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'show'])->name('purchase_orders.show')->middleware('privilege:purchase_orders');
    Route::put('/purchase-orders/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'update'])->name('purchase_orders.update')->middleware('privilege:purchase_orders');
    Route::delete('/purchase-orders/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'destroy'])->name('purchase_orders.destroy')->middleware('privilege:purchase_orders');
    Route::post('/purchase-orders/{id}/receive', [App\Http\Controllers\PurchaseOrderController::class, 'receive'])->name('purchase_orders.receive')->middleware('privilege:purchase_orders');


    Route::get('/settings/print', [App\Http\Controllers\PrintSettingController::class, 'index'])->name('settings.print')->middleware('privilege:settings_store');
    Route::post('/settings/print', [App\Http\Controllers\PrintSettingController::class, 'store'])->name('settings.print.store')->middleware('privilege:settings_store');

    Route::get('/settings/store', [App\Http\Controllers\StoreSettingController::class, 'index'])->name('settings.store')->middleware('privilege:settings_store');
    Route::post('/settings/store', [App\Http\Controllers\StoreSettingController::class, 'store'])->name('settings.store.store')->middleware('privilege:settings_store');
});

Route::middleware(['auth', 'subscription.active'])->group(function () {
    // Subscription Payment Routes
    Route::get('/subscription/payment', [App\Http\Controllers\SubscriptionController::class, 'payment'])->name('subscription.payment');
    Route::post('/subscription/payment', [App\Http\Controllers\SubscriptionController::class, 'uploadProof'])->name('subscription.payment.upload');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Manual Sync for Local POS
    Route::post('/manual-sync', function () {
        \Illuminate\Support\Facades\Artisan::call('sync:run');
        return back()->with('success', 'Manual Sync Completed Successfully!');
    })->name('manual.sync');

    // API endpoints for AJAX fetch
    Route::get('/api/categories', [App\Http\Controllers\CategoryController::class, 'apiIndex']);
    Route::get('/api/medicines', [App\Http\Controllers\MedicineController::class, 'apiIndex']);
    Route::get('/api/suppliers', [App\Http\Controllers\SupplierController::class, 'apiIndex']);
    Route::get('/api/customers', [App\Http\Controllers\CustomerController::class, 'apiIndex']);
    Route::get('/api/sales', [App\Http\Controllers\SaleController::class, 'apiIndex']);
    Route::post('/api/sales/{id}/refund', [App\Http\Controllers\SaleController::class, 'refund'])->middleware('privilege:pos');
    Route::post('/api/sales/{id}/edit', [App\Http\Controllers\SaleController::class, 'editInvoice'])->middleware('privilege:pos');
    Route::get('/api/expenses', [App\Http\Controllers\ExpenseController::class, 'apiIndex']);
    
    // Staff Management API Routes
    Route::get('/api/staff', [App\Http\Controllers\StaffController::class, 'apiIndex']);
    Route::post('/api/staff', [App\Http\Controllers\StaffController::class, 'store'])->middleware('privilege:staff');
    Route::put('/api/staff/{id}', [App\Http\Controllers\StaffController::class, 'update'])->middleware('privilege:staff');
    Route::delete('/api/staff/{id}', [App\Http\Controllers\StaffController::class, 'destroy'])->middleware('privilege:staff');
    Route::post('/api/staff/{id}/otp', [App\Http\Controllers\StaffController::class, 'saveOtp'])->middleware('privilege:staff');
    Route::post('/api/staff/{id}/force-logout', [App\Http\Controllers\StaffController::class, 'forceLogout'])->middleware('privilege:staff');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalSales = \App\Models\PaymentRequest::join('packages', 'payment_requests.package_id', '=', 'packages.id')
            ->where('payment_requests.status', 'approved')
            ->sum('packages.price');
            
        $wallets = \App\Models\SellerWallet::all();
        $totalCommissionPaid = $wallets->where('status', 'paid')->sum('c_amount');
        $totalCommissionPending = $wallets->where('status', 'unpaid')->sum('c_amount');
        $totalUsers = \App\Models\User::count();
        $totalStores = \App\Models\User::where('type', 'store')->count();
        $totalSellers = \App\Models\User::where('type', 'seller')->count();

        return view('admin.dashboard', compact('totalSales', 'totalCommissionPaid', 'totalCommissionPending', 'totalUsers', 'totalStores', 'totalSellers'));
    })->name('dashboard');

    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/sellers', [App\Http\Controllers\Admin\UserController::class, 'sellers'])->name('sellers.index');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::resource('packages', App\Http\Controllers\Admin\PackageController::class);
    Route::post('/users/{user}/toggle-subscription', [App\Http\Controllers\Admin\UserController::class, 'toggleSubscription'])->name('users.toggle-subscription');
    Route::post('/users/{user}/toggle-sync', [App\Http\Controllers\Admin\UserController::class, 'toggleSync'])->name('users.toggle-sync');

    Route::get('/payments', [App\Http\Controllers\Admin\PaymentRequestController::class, 'index'])->name('payments.index');
    Route::post('/payments/{paymentRequest}/approve', [App\Http\Controllers\Admin\PaymentRequestController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{paymentRequest}/reject', [App\Http\Controllers\Admin\PaymentRequestController::class, 'reject'])->name('payments.reject');

    Route::get('/wallets', [App\Http\Controllers\Admin\SellerWalletController::class, 'index'])->name('wallets.index');
    Route::post('/wallets/{wallet}/mark-paid', [App\Http\Controllers\Admin\SellerWalletController::class, 'markAsPaid'])->name('wallets.mark-paid');

});

// Seller Routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', function () {
        $packages = \App\Models\Package::where('status', 'active')->get();
        
        $stores = \App\Models\User::with(['package', 'subscriptions' => function($query) {
            $query->latest();
        }])->where('type', 'store')->where('parent_id', auth()->id())->get();

        $wallets = \App\Models\SellerWallet::where('seller_id', auth()->id())->get();
        $totalEarned = $wallets->sum('c_amount');
        $totalPaid = $wallets->where('status', 'paid')->sum('c_amount');
        $totalPending = $wallets->where('status', 'unpaid')->sum('c_amount');

        return view('seller.dashboard', compact('packages', 'stores', 'totalEarned', 'totalPaid', 'totalPending'));
    })->name('dashboard');

    Route::get('/commissions', function () {
        $wallets = \App\Models\SellerWallet::with(['store', 'subscription.package'])
            ->where('seller_id', auth()->id())
            ->latest()
            ->get();
        return view('seller.commissions', compact('wallets'));
    })->name('commissions');

    Route::get('/payout-settings', function () {
        return view('seller.payout');
    })->name('payout');

    Route::post('/payout-settings', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'payout_method' => 'required|string',
            'payout_account_name' => 'required|string',
            'payout_account_number' => 'required|string',
            'payout_bank_name' => 'nullable|string',
        ]);

        auth()->user()->update($request->only('payout_method', 'payout_account_name', 'payout_account_number', 'payout_bank_name'));

        return back()->with('success', 'Payout settings updated successfully!');
    })->name('payout.update');
});

require __DIR__.'/auth.php';

// Google Social Login Routes
use App\Http\Controllers\Auth\GoogleLoginController;
Route::get('auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);



