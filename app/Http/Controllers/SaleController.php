<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Sale;

class SaleController extends Controller
{
    public function index() { return view('sales.index'); }
    public function invoices() { return view('sales.invoices'); }
    
    public function apiIndex() {
        $sales = Sale::with(['customer', 'items.medicine'])->orderBy('id', 'desc')->get();
        
        $formatted = $sales->map(function($sale) {
            $items = $sale->items->map(function($item) {
                return [
                    'medicine_id' => $item->medicine_id,
                    'name' => $item->medicine ? $item->medicine->name : 'Unknown Medicine',
                    'price' => $item->unit_price,
                    'qty' => $item->quantity,
                    'sub' => $item->subtotal
                ];
            });
            
            $discAmt = $sale->subtotal * ($sale->discount_percent / 100);
            $taxAmt = ($sale->subtotal - $discAmt) * ($sale->tax_percent / 100);
            
            return [
                'id' => $sale->invoice_number,
                'custId' => $sale->customer_id,
                'custName' => $sale->customer ? $sale->customer->name : 'Walk-in Customer',
                'items' => $items,
                'subtotal' => (float)$sale->subtotal,
                'discount' => (float)$sale->discount_percent,
                'tax' => (float)$sale->tax_percent,
                'discAmt' => (float)$discAmt,
                'taxAmt' => (float)$taxAmt,
                'grand' => (float)$sale->grand_total,
                'paid' => (float)$sale->paid_amount,
                'due' => (float)$sale->due_amount,
                'ret' => (float)$sale->return_amount,
                'payment' => $sale->payment_method,
                'notes' => $sale->notes,
                'date' => $sale->created_at->toISOString(),
                'cashier' => 'Admin'
            ];
        });
        
        return response()->json($formatted);
    }
}
