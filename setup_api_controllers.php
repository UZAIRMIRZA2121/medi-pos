<?php
$controllers = [
    'CategoryController.php' => '<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() { return response()->json(Category::all()); }
    public function store(Request $request) {
        $data = $request->validate(["name" => "required|string", "description" => "nullable|string", "color_tag" => "nullable|string"]);
        $category = Category::create($data);
        return response()->json($category);
    }
    public function show(Category $category) { return response()->json($category); }
    public function update(Request $request, Category $category) {
        $data = $request->validate(["name" => "required|string", "description" => "nullable|string", "color_tag" => "nullable|string"]);
        $category->update($data);
        return response()->json($category);
    }
    public function destroy(Category $category) {
        $category->delete();
        return response()->json(["message" => "Deleted"]);
    }
}',
    'SupplierController.php' => '<?php
namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index() { return response()->json(Supplier::all()); }
    public function store(Request $request) {
        $data = $request->validate(["name" => "required|string", "company_name" => "nullable|string", "phone" => "required|string", "email" => "nullable|email", "address" => "nullable|string", "notes" => "nullable|string"]);
        $supplier = Supplier::create($data);
        return response()->json($supplier);
    }
    public function show(Supplier $supplier) { return response()->json($supplier); }
    public function update(Request $request, Supplier $supplier) {
        $data = $request->validate(["name" => "required|string", "company_name" => "nullable|string", "phone" => "required|string", "email" => "nullable|email", "address" => "nullable|string", "notes" => "nullable|string"]);
        $supplier->update($data);
        return response()->json($supplier);
    }
    public function destroy(Supplier $supplier) {
        $supplier->delete();
        return response()->json(["message" => "Deleted"]);
    }
}',
    'CustomerController.php' => '<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() { return response()->json(Customer::orderBy("id", "desc")->get()); }
    public function store(Request $request) {
        $data = $request->validate(["name" => "required|string", "phone" => "required|string", "email" => "nullable|email", "age" => "nullable|integer", "gender" => "nullable|string", "address" => "nullable|string"]);
        $customer = Customer::create($data);
        return response()->json($customer);
    }
    public function show(Customer $customer) { return response()->json($customer); }
    public function update(Request $request, Customer $customer) {
        $data = $request->validate(["name" => "required|string", "phone" => "required|string", "email" => "nullable|email", "age" => "nullable|integer", "gender" => "nullable|string", "address" => "nullable|string"]);
        $customer->update($data);
        return response()->json($customer);
    }
    public function destroy(Customer $customer) {
        $customer->delete();
        return response()->json(["message" => "Deleted"]);
    }
}',
    'MedicineController.php' => '<?php
namespace App\Http\Controllers;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index() { return response()->json(Medicine::with(["category", "supplier"])->get()); }
    public function store(Request $request) {
        $data = $request->validate([
            "category_id" => "required|exists:categories,id",
            "supplier_id" => "nullable|exists:suppliers,id",
            "name" => "required|string",
            "generic_name" => "nullable|string",
            "company" => "nullable|string",
            "batch_number" => "nullable|string",
            "barcode" => "nullable|string",
            "purchase_price" => "required|numeric",
            "sale_price" => "required|numeric",
            "stock_quantity" => "required|integer",
            "low_stock_level" => "required|integer",
            "expiry_date" => "nullable|date",
            "mfg_date" => "nullable|date",
            "rack" => "nullable|string",
            "requires_prescription" => "boolean",
            "description" => "nullable|string",
        ]);
        $medicine = Medicine::create($data);
        return response()->json($medicine->load(["category", "supplier"]));
    }
    public function show(Medicine $medicine) { return response()->json($medicine->load(["category", "supplier"])); }
    public function update(Request $request, Medicine $medicine) {
        $data = $request->validate([
            "category_id" => "required|exists:categories,id",
            "supplier_id" => "nullable|exists:suppliers,id",
            "name" => "required|string",
            "generic_name" => "nullable|string",
            "company" => "nullable|string",
            "batch_number" => "nullable|string",
            "barcode" => "nullable|string",
            "purchase_price" => "required|numeric",
            "sale_price" => "required|numeric",
            "stock_quantity" => "required|integer",
            "low_stock_level" => "required|integer",
            "expiry_date" => "nullable|date",
            "mfg_date" => "nullable|date",
            "rack" => "nullable|string",
            "requires_prescription" => "boolean",
            "description" => "nullable|string",
        ]);
        $medicine->update($data);
        return response()->json($medicine->load(["category", "supplier"]));
    }
    public function destroy(Medicine $medicine) {
        $medicine->delete();
        return response()->json(["message" => "Deleted"]);
    }
}'
];

foreach ($controllers as $name => $content) {
    file_put_contents('app/Http/Controllers/' . $name, $content);
}
echo "Controllers replaced.\n";
