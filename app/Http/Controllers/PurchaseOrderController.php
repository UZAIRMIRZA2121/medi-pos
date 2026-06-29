<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index(Request $request) {
        $query = \App\Models\PurchaseOrder::with('supplier')
            ->where('user_id', auth()->id());
            
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }
            
        $orders = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
            
        return view('purchase_orders.index', compact('orders'));
    }

    public function show($id) {
        $order = \App\Models\PurchaseOrder::with(['supplier', 'items.medicine'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
            
        return response()->json($order);
    }

    public function receive($id) {
        $order = \App\Models\PurchaseOrder::with('items.medicine')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Order is already processed.']);
        }

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            foreach ($order->items as $item) {
                if ($item->medicine) {
                    $units = $item->quantity * ($item->medicine->items_per_pack ?: 1);
                    $item->medicine->increment('stock_quantity', $units);
                    
                    if ($item->medicine->pack_stock_quantity !== null) {
                        $item->medicine->increment('pack_stock_quantity', $item->quantity);
                    }
                }
            }
            $order->update(['status' => 'received']);
            \Illuminate\Support\Facades\DB::commit();
            return response()->json(['success' => true, 'message' => 'Order marked as received and stock updated.']);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function store(Request $request) {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:medicines,id',
            'items.*.qty' => 'required|integer|min:1'
        ]);

        $supplier = \App\Models\Supplier::findOrFail($request->supplier_id);
        
        // Generate Order Number
        $orderCount = \App\Models\PurchaseOrder::where('user_id', auth()->id())->count();
        $orderNumber = 'PO-' . str_pad($orderCount + 1, 5, '0', STR_PAD_LEFT);

        $order = \App\Models\PurchaseOrder::create([
            'user_id' => auth()->id(),
            'supplier_id' => $supplier->id,
            'order_number' => $orderNumber,
            'status' => 'pending',
            'total_items' => count($request->items),
            'total_amount' => 0,
            'notes' => $request->notes
        ]);

        $totalAmount = 0;

        foreach ($request->items as $item) {
            $medicine = \App\Models\Medicine::find($item['id']);
            if ($medicine) {
                $price = $medicine->pack_purchase_price > 0 ? $medicine->pack_purchase_price : ($medicine->purchase_price * ($medicine->items_per_pack ?: 1));
                $subtotal = $price * $item['qty'];
                $totalAmount += $subtotal;

                \App\Models\PurchaseOrderItem::create([
                    'purchase_order_id' => $order->id,
                    'medicine_id' => $medicine->id,
                    'quantity' => $item['qty'],
                    'purchase_price' => $price,
                    'subtotal' => $subtotal
                ]);
            }
        }

        $order->update(['total_amount' => $totalAmount]);

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'message' => 'Purchase order saved successfully.'
        ]);
    }

    public function update(Request $request, $id) {
        $order = \App\Models\PurchaseOrder::where('user_id', auth()->id())->findOrFail($id);
        
        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Cannot edit processed orders.']);
        }
        
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:purchase_order_items,id',
            'items.*.qty' => 'required|integer|min:1'
        ]);
        
        $totalAmount = 0;
        
        foreach ($request->items as $itemData) {
            $item = \App\Models\PurchaseOrderItem::where('purchase_order_id', $order->id)->find($itemData['id']);
            if ($item) {
                $subtotal = $item->purchase_price * $itemData['qty'];
                $totalAmount += $subtotal;
                $item->update([
                    'quantity' => $itemData['qty'],
                    'subtotal' => $subtotal
                ]);
            }
        }
        
        $order->update([
            'total_amount' => $totalAmount
        ]);
        
        return response()->json(['success' => true, 'message' => 'Purchase order updated successfully.']);
    }
}
