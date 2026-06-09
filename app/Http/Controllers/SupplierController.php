<?php
namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index() { return view('suppliers.index'); }
    public function apiIndex() { return response()->json(Supplier::all()); }
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
}