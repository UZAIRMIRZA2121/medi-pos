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
              <th>Total Items</th>
              <th>Total Price</th>
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
              <td>{{ $order->total_items }}</td>
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
                <button class="btn btn-sm btn-outline" onclick="openOrderDetails({{ $order->id }})">Details</button>
                @if($order->status == 'pending')
                  <button class="btn btn-sm btn-primary" onclick="markOrderReceived({{ $order->id }})">Received</button>
                @endif
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
