<?php
namespace App\Http\Controllers;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index() { return view('medicines.index'); }
    public function apiIndex() { return response()->json(Medicine::with(["category", "supplier"])->get()); }
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
            "pack_purchase_price" => "nullable|numeric",
            "pack_sale_price" => "nullable|numeric",
            "pack_stock_quantity" => "nullable|integer",
            "items_per_pack" => "nullable|integer",
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
            "pack_purchase_price" => "nullable|numeric",
            "pack_sale_price" => "nullable|numeric",
            "pack_stock_quantity" => "nullable|integer",
            "items_per_pack" => "nullable|integer",
        ]);
        $medicine->update($data);
        return response()->json($medicine->load(["category", "supplier"]));
    }
    public function destroy(Medicine $medicine) {
        $medicine->delete();
        return response()->json(["message" => "Deleted"]);
    }
}