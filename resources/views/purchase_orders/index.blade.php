@extends('layouts.app')

@section('content')
<main class="page-content">
  <div class="page" id="page-purchase-orders">
    <div class="card">
      <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
        <h3>Purchase Orders</h3>
        <form action="{{ route('purchase_orders.index') }}" method="GET" style="display:flex; gap:10px;">
          <input type="text" name="search" class="input input-sm" placeholder="Search PO or Supplier..." value="{{ request('search') }}">
          <button type="submit" class="btn btn-sm btn-primary">Search</button>
          @if(request('search'))
            <a href="{{ route('purchase_orders.index') }}" class="btn btn-sm btn-ghost">Clear</a>
          @endif
        </form>
      </div>
      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th>Order No</th>
              <th>Date</th>
              <th>Supplier</th>
              <th>Total Packs</th>
              <th>Purchase Price</th>
              <th>Notes</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $order)
            <tr>
              <td><span class="badge" style="background:#e2e8f0;color:#1e293b;">{{ $order->order_number }}</span></td>
              <td>{{ $order->created_at->format('d M Y h:i A') }}</td>
              <td>{{ $order->supplier->name ?? 'Unknown' }}</td>
              <td>{{ $order->items->sum('quantity') }}</td>
              <td style="font-weight:600;">Rs {{ number_format($order->total_amount, 2) }}</td>
              <td>
                @if($order->notes)
                  <span title="{{ $order->notes }}">{{ Str::limit($order->notes, 20) }}</span>
                @else
                  <span style="color:#94a3b8;">-</span>
                @endif
              </td>
              <td>
                @if($order->status == 'pending')
                  <span class="badge" style="background:#fef3c7;color:#92400e;">Pending</span>
                @elseif($order->status == 'received')
                  <span class="badge" style="background:#d1fae5;color:#065f46;">Received</span>
                @else
                  <span class="badge" style="background:#f1f5f9;color:#334155;">{{ ucfirst($order->status) }}</span>
                @endif
              </td>
              <td style="display: flex; gap: 5px;">
                <button class="action-btn" onclick="openOrderDetails({{ $order->id }})" title="Details">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
                <button class="action-btn" onclick="printPurchaseOrder({{ $order->id }})" title="Print">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                </button>
                @if($order->status == 'pending')
                  <button class="action-btn edit" onclick="editPurchaseOrder({{ $order->id }})" title="Edit">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                  </button>
                  <button class="action-btn" style="color:#059669; background:#d1fae5;" onclick="markOrderReceived({{ $order->id }})" title="Mark Received">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                  </button>
                @endif
                <button class="action-btn del" onclick="deletePurchaseOrder({{ $order->id }})" title="Delete">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" style="text-align:center;padding:20px;color:#64748b;">No purchase orders found. Generate one from the Suppliers page.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      
      <div style="padding: 15px;">
          {{ $orders->links() }}
      </div>
    </div>
  </div>
</main>
@endsection
