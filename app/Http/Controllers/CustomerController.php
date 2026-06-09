<?php
namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() { return view('customers.index'); }
    public function apiIndex() { return response()->json(Customer::orderBy("id", "desc")->get()); }
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
}