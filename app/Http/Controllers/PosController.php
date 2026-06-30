<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Medicine;
use App\Models\Customer;

class PosController extends Controller
{
    public function index() {
        $settings = \App\Models\BusinessSetting::where('user_id', auth()->id())->first();
        return view('pos.billing', compact('settings'));
    }
    
    public function checkout(Request $request) {
        $data = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'discount_percent' => 'numeric|min:0|max:100',
            'tax_percent' => 'numeric|min:0|max:100',
            'paid_amount' => 'numeric|min:0',
            'payment_method' => 'string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();
            
            $subtotal = 0;
            $total_items = 0;
            $items_details = [];
            
            foreach ($data['items'] as $item) {
                $medicine = Medicine::findOrFail($item['medicine_id']);
                
                if ($medicine->stock_quantity < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$medicine->name}");
                }
                
                $medicine->stock_quantity -= $item['quantity'];
                $medicine->save();
                
                $item_subtotal = $item['quantity'] * $medicine->sale_price;
                $subtotal += $item_subtotal;
                $total_items += $item['quantity'];
                
                $items_details[] = [
                    'medicine_id' => $medicine->id,
                    'name' => $medicine->name, // For the frontend format
                    'price' => $medicine->sale_price,
                    'qty' => $item['quantity'],
                    'sub' => $item_subtotal
                ];
            }
            
            $discount_percent = $data['discount_percent'] ?? 0;
            $tax_percent = $data['tax_percent'] ?? 0;
            
            $discAmt = $subtotal * ($discount_percent / 100);
            $taxAmt = ($subtotal - $discAmt) * ($tax_percent / 100);
            $grand = $subtotal - $discAmt + $taxAmt;
            
            $paid = $data['paid_amount'] ?? 0;
            $due = max(0, $grand - $paid);
            $ret = max(0, $paid - $grand);
            
            // Generate Invoice ID e.g., INV1004
            $storeSaleCount = Sale::count();
            $nextId = 1001 + $storeSaleCount;
            $invoice_number = 'INV' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            
            $sale = Sale::create([
                'customer_id' => $data['customer_id'],
                'staff_id' => session('staff_id'),
                'invoice_number' => $invoice_number,
                'total_items' => $total_items,
                'subtotal' => $subtotal,
                'discount_percent' => $discount_percent,
                'tax_percent' => $tax_percent,
                'grand_total' => $grand,
                'paid_amount' => $paid,
                'due_amount' => $due,
                'return_amount' => $ret,
                'payment_method' => $data['payment_method'] ?? 'cash',
                'notes' => $data['notes'] ?? ''
            ]);
            
            foreach ($items_details as $detail) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'medicine_id' => $detail['medicine_id'],
                    'quantity' => $detail['qty'],
                    'unit_price' => $detail['price'],
                    'subtotal' => $detail['sub']
                ]);
            }
            
            DB::commit();
            
            $customer = $data['customer_id'] ? Customer::find($data['customer_id']) : null;
            
            // Format to match what script.js showInvoiceModal expects
            return response()->json([
                'id' => $invoice_number,
                'custId' => $data['customer_id'],
                'custName' => $customer ? $customer->name : 'Walk-in Customer',
                'items' => $items_details,
                'subtotal' => $subtotal,
                'discount' => $discount_percent,
                'tax' => $tax_percent,
                'discAmt' => $discAmt,
                'taxAmt' => $taxAmt,
                'grand' => $grand,
                'paid' => $paid,
                'due' => $due,
                'ret' => $ret,
                'payment' => $data['payment_method'] ?? 'cash',
                'notes' => $data['notes'] ?? '',
                'date' => $sale->created_at->toISOString(),
                'cashier' => session()->has('staff_name') ? session('staff_name') : 'Admin'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
}
