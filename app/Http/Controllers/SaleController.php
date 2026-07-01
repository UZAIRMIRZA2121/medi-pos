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

            $newPaidAmt = $request->input('paid_amount');
            if (!is_null($newPaidAmt) && $newPaidAmt !== '') {
                $sale->paid_amount = $newPaidAmt;
            }

            foreach ($itemsToRefund as $refData) {
                $med = \App\Models\Medicine::find($refData['medicine_id']);
                if ($med) {
                    $med->increment('stock_quantity', $refData['refund_qty']);
                }

                $originalItem = $sale->items()->where('medicine_id', $refData['medicine_id'])->first();
                if ($originalItem) {
                    $originalItem->quantity -= $refData['refund_qty'];
                    $originalItem->subtotal = $originalItem->quantity * $originalItem->unit_price;
                    $originalItem->save();

                    if ($originalItem->quantity <= 0) {
                        $originalItem->delete();
                    }
                }
            }

            // Recalculate sale totals
            $newSubtotal = $sale->items()->sum('subtotal');
            $newTotalQty = $sale->items()->sum('quantity');

            $discAmt = $newSubtotal * ($sale->discount_percent / 100);
            $taxAmt = ($newSubtotal - $discAmt) * ($sale->tax_percent / 100);
            $newGrandTotal = $newSubtotal - $discAmt + $taxAmt;

            $sale->total_items = $newTotalQty;
            $sale->subtotal = $newSubtotal;
            $sale->grand_total = $newGrandTotal;

            if ($sale->paid_amount >= $newGrandTotal) {
                $sale->return_amount = $sale->paid_amount - $newGrandTotal;
                $sale->due_amount = 0;
            } else {
                $sale->due_amount = $newGrandTotal - $sale->paid_amount;
                $sale->return_amount = 0;
            }

            if ($newTotalQty <= 0) {
                $sale->delete();
                $msg = 'Refund processed successfully. Invoice was fully refunded and deleted.';
            } else {
                $sale->save();
                $msg = 'Refund processed successfully. Invoice updated.';
            }
                
            \DB::commit();
            return response()->json(['success' => true, 'message' => $msg]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error processing refund: ' . $e->getMessage()]);
        }
    }
    public function editInvoice(Request $request, $id) {
        $sale = Sale::where('invoice_number', $id)->firstOrFail();

        $request->validate([
            'discount_percent' => 'numeric|min:0|max:100',
            'tax_percent' => 'numeric|min:0|max:100',
            'paid_amount' => 'numeric|min:0'
        ]);

        $sale->discount_percent = $request->input('discount_percent', $sale->discount_percent);
        $sale->tax_percent = $request->input('tax_percent', $sale->tax_percent);
        $sale->paid_amount = $request->input('paid_amount', $sale->paid_amount);

        // Recalculate totals
        $subtotal = $sale->subtotal;
        $discAmt = $subtotal * ($sale->discount_percent / 100);
        $taxAmt = ($subtotal - $discAmt) * ($sale->tax_percent / 100);
        $grandTotal = $subtotal - $discAmt + $taxAmt;

        $sale->grand_total = $grandTotal;

        if ($sale->paid_amount >= $grandTotal) {
            $sale->return_amount = $sale->paid_amount - $grandTotal;
            $sale->due_amount = 0;
        } else {
            $sale->due_amount = $grandTotal - $sale->paid_amount;
            $sale->return_amount = 0;
        }

        $sale->save();

        return response()->json(['success' => true, 'message' => 'Invoice updated successfully.']);
    }
}
