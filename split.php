<?php

$content = file_get_contents('resources/views/pos/index.blade.php');

$pages = [
    'DASHBOARD' => 'dashboard/index.blade.php',
    'POS' => 'pos/billing.blade.php',
    'INVOICES' => 'sales/invoices.blade.php',
    'SALES' => 'sales/index.blade.php',
    'MEDICINES' => 'medicines/index.blade.php',
    'CATEGORIES' => 'categories/index.blade.php',
    'SUPPLIERS' => 'suppliers/index.blade.php',
    'CUSTOMERS' => 'customers/index.blade.php',
    'ALERTS' => 'alerts/index.blade.php',
];

$keys = array_keys($pages);

foreach ($keys as $index => $key) {
    $startMarker = "<!-- $key -->";
    $endMarker = isset($keys[$index + 1]) ? "<!-- " . $keys[$index + 1] . " -->" : "</main>";
    
    $startPos = strpos($content, $startMarker);
    $endPos = strpos($content, $endMarker, $startPos);
    
    $pageHtml = substr($content, $startPos, $endPos - $startPos);
    
    // Remove 'hidden' class so it shows on load
    $pageHtml = str_replace('class="page hidden"', 'class="page"', $pageHtml);
    
    // Wrap in layout
    $blade = "@extends('layouts.app')\n\n@section('content')\n<main class=\"page-content\">\n\n" . trim($pageHtml) . "\n\n</main>\n@endsection\n";
    
    $filePath = 'resources/views/' . $pages[$key];
    $dir = dirname($filePath);
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    
    file_put_contents($filePath, $blade);
    echo "Created $filePath\n";
}

// Now update web.php routes
$routes = "
Route::middleware(['auth'])->group(function () {
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
});
";
$webphp = file_get_contents('routes/web.php');
$webphp = preg_replace("/Route::middleware\(\['auth'\]\)->group\(function \(\) \{.*\}\);/s", trim($routes), $webphp);
file_put_contents('routes/web.php', $webphp);
echo "Updated routes/web.php\n";

// Update sidebar links
$sidebar = file_get_contents('resources/views/partials/sidebar.blade.php');
$sidebar = str_replace('data-page="dashboard"', 'href="{{ route(\'dashboard\') }}"', $sidebar);
$sidebar = str_replace('data-page="pos"', 'href="{{ route(\'pos.index\') }}"', $sidebar);
$sidebar = str_replace('data-page="invoices"', 'href="{{ route(\'invoices.index\') }}"', $sidebar);
$sidebar = str_replace('data-page="sales"', 'href="{{ route(\'sales.index\') }}"', $sidebar);
$sidebar = str_replace('data-page="medicines"', 'href="{{ route(\'medicines.index\') }}"', $sidebar);
$sidebar = str_replace('data-page="categories"', 'href="{{ route(\'categories.index\') }}"', $sidebar);
$sidebar = str_replace('data-page="suppliers"', 'href="{{ route(\'suppliers.index\') }}"', $sidebar);
$sidebar = str_replace('data-page="customers"', 'href="{{ route(\'customers.index\') }}"', $sidebar);
$sidebar = str_replace('data-page="alerts"', 'href="{{ route(\'alerts.index\') }}"', $sidebar);
$sidebar = str_replace('class="nav-item active"', 'class="nav-item"', $sidebar); // Remove active class, let's let JS or PHP handle it later if needed
file_put_contents('resources/views/partials/sidebar.blade.php', $sidebar);
echo "Updated sidebar.blade.php\n";
