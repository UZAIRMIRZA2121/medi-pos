<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Sale;

class SaleController extends Controller
{
    public function index() { return view('sales.index'); }
    public function invoices() { return view('sales.invoices'); }
    
    public function apiIndex() {
        $sales = Sale::with(['customer', 'staff', 'items.medicine'])->orderBy('id', 'desc')->get();
        
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
                'cashier' => $sale->staff ? $sale->staff->name : 'Admin'
            ];
        });
        
        return response()->json($formatted);
    }
    public function refund(Request $request, $id) {
        $sale = Sale::where('invoice_number', $id)->firstOrFail();
        $type = $request->input('type');
        
        \DB::beginTransaction();
        try {
            $itemsToRefund = [];
            if ($type === 'full') {
                foreach ($sale->items as $item) {
                    $itemsToRefund[] = [
                        'medicine_id' => $item->medicine_id,
                        'refund_qty' => $item->quantity,
                        'unit_price' => $item->unit_price
                    ];
                }
            } else {
                foreach ($request->input('items', []) as $reqItem) {
                    $originalItem = $sale->items()->where('medicine_id', $reqItem['medicine_id'])->first();
                    if ($originalItem && $reqItem['refund_qty'] > 0) {
                        $itemsToRefund[] = [
                            'medicine_id' => $originalItem->medicine_id,
                            'refund_qty' => min($reqItem['refund_qty'], $originalItem->quantity),
                            'unit_price' => $originalItem->unit_price
                        ];
                    }
                }
            }

            if (count($itemsToRefund) === 0) {
                return response()->json(['success' => false, 'message' => 'No items to refund.']);
            }

            $refundSubtotal = 0;
            $refundTotalQty = 0;

            $refundSale = new Sale();
            $refundSale->invoice_number = 'REF-' . $sale->invoice_number . '-' . time();
            $refundSale->customer_id = $sale->customer_id;
            $refundSale->payment_method = 'refund';
            $refundSale->discount_percent = $sale->discount_percent;
            $refundSale->tax_percent = $sale->tax_percent;
            $refundSale->user_id = auth()->id() ?? $sale->user_id;
            $refundSale->staff_id = session('staff_id');
            // Store temporarily to get ID
            $refundSale->total_items = 0;
            $refundSale->subtotal = 0;
            $refundSale->grand_total = 0;
            $refundSale->save();

            foreach ($itemsToRefund as $refData) {
                $med = \App\Models\Medicine::find($refData['medicine_id']);
                if ($med) {
                    $med->increment('stock_quantity', $refData['refund_qty']);
                }
                
                $itemSubtotal = $refData['refund_qty'] * $refData['unit_price'];
                $refundSubtotal += $itemSubtotal;
                $refundTotalQty += $refData['refund_qty'];

                $refundSale->items()->create([
                    'medicine_id' => $refData['medicine_id'],
                    'quantity' => -$refData['refund_qty'],
                    'unit_price' => $refData['unit_price'],
                    'subtotal' => -$itemSubtotal
                ]);
            }

            $discAmt = $refundSubtotal * ($sale->discount_percent / 100);
            $taxAmt = ($refundSubtotal - $discAmt) * ($sale->tax_percent / 100);
            $refundGrandTotal = $refundSubtotal - $discAmt + $taxAmt;

            $refundSale->total_items = -$refundTotalQty;
            $refundSale->subtotal = -$refundSubtotal;
            $refundSale->grand_total = -$refundGrandTotal;
            $refundSale->paid_amount = 0;
            $refundSale->due_amount = 0;
            $refundSale->return_amount = $refundGrandTotal;
            $refundSale->save();
                
                \DB::commit();
            return response()->json(['success' => true, 'message' => 'Refund processed successfully. New Refund Invoice created.']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error processing refund: ' . $e->getMessage()]);
        }
    }
}
