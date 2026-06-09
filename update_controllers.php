<?php

$controllers = [
    'CategoryController' => 'categories.index',
    'MedicineController' => 'medicines.index',
    'SupplierController' => 'suppliers.index',
    'CustomerController' => 'customers.index',
];

foreach ($controllers as $name => $view) {
    $path = "app/Http/Controllers/$name.php";
    if (!file_exists($path)) continue;
    $content = file_get_contents($path);
    
    $content = preg_replace('/public function index\(\) \{ return response\(\)->json\((.*?)\); \}/', 
        "public function index() { return view('$view'); }\n    public function apiIndex() { return response()->json($1); }", 
        $content);
        
    file_put_contents($path, $content);
    echo "Updated $name\n";
}

// Re-write DashboardController to still pass the stats, but return dashboard.index
$dash = file_get_contents('app/Http/Controllers/DashboardController.php');
$dash = str_replace("return view('pos.index'", "return view('dashboard.index'", $dash);
file_put_contents('app/Http/Controllers/DashboardController.php', $dash);
echo "Updated DashboardController\n";

// Update PosController
$pos = "<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index() { return view('pos.billing'); }
    public function checkout() { return response()->json(['message' => 'Checkout success']); }
}
";
file_put_contents('app/Http/Controllers/PosController.php', $pos);
echo "Updated PosController\n";

// Update SaleController
$sale = "<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index() { return view('sales.index'); }
    public function invoices() { return view('sales.invoices'); }
}
";
file_put_contents('app/Http/Controllers/SaleController.php', $sale);
echo "Updated SaleController\n";

// Update AlertController
$alert = "<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index() { return view('alerts.index'); }
}
";
file_put_contents('app/Http/Controllers/AlertController.php', $alert);
echo "Updated AlertController\n";

// Update script.js URLs
$script = file_get_contents('public/assets/js/script.js');
$script = str_replace("api('/categories'", "api('/api/categories'", $script);
$script = str_replace("api('/medicines'", "api('/api/medicines'", $script);
$script = str_replace("api('/suppliers'", "api('/api/suppliers'", $script);
$script = str_replace("api('/customers'", "api('/api/customers'", $script);
// Remove navigate() logic
$script = preg_replace("/function navigate\(page\) \{[\s\S]*?\n\}/", "function navigate(page) { window.location.href = '/' + page; }", $script);

// Since syncData() calls renderPage(currentPage), but we don't have navigate() managing currentPage anymore.
// We need to figure out the current page based on the URL path.
$script = str_replace("renderPage(currentPage);", "
        const path = window.location.pathname.replace(/^\/|\/$/g, '') || 'dashboard';
        const fnMap = {
            'categories': renderCategories,
            'medicines': renderMedicines,
            'suppliers': renderSuppliers,
            'customers': renderCustomers,
            'alerts': renderAlerts,
            'sales': renderSales,
            'invoices': renderInvoices,
            'pos': renderPOS
        };
        if(fnMap[path]) fnMap[path]();
", $script);

file_put_contents('public/assets/js/script.js', $script);
echo "Updated script.js\n";
