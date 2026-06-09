@extends('layouts.app')

@section('content')
<main class="page-content">

<!-- DASHBOARD -->
    <div class="page" id="page-dashboard">
      <div class="stat-grid" id="dashStats">
        <div class="stat-card">
          <div class="stat-icon" style="background:#e6f0ff;color:#0066cc">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
          </div>
          <div>
            <div class="stat-value">{{ $totalMedicines ?? 0 }}</div>
            <div class="stat-label">Total Medicines</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#ede9fe;color:#6366f1">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
          </div>
          <div>
            <div class="stat-value">{{ $totalCategories ?? 0 }}</div>
            <div class="stat-label">Categories</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#fef3c7;color:#f59e0b">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg>
          </div>
          <div>
            <div class="stat-value">{{ $lowStockCount ?? 0 }}</div>
            <div class="stat-label">Low Stock</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#fee2e2;color:#ef4444">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
          </div>
          <div>
            <div class="stat-value">{{ $expiredCount ?? 0 }}</div>
            <div class="stat-label">Expired</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#d1fae5;color:#10b981">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <div>
            <div class="stat-value">Rs. {{ number_format($todaySalesSum ?? 0, 2) }}</div>
            <div class="stat-label">Today Sales</div>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon" style="background:#fce7f3;color:#ec4899">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          </div>
          <div>
            <div class="stat-value">{{ $totalInvoices ?? 0 }}</div>
            <div class="stat-label">Total Invoices</div>
          </div>
        </div>
      </div>
      <div class="dash-grid">
        <div class="card">
          <div class="card-header">
            <h3>Recent Sales</h3>
            <button class="btn btn-sm btn-ghost" onclick="navigate('sales')">View All</button>
          </div>
          <div class="table-wrap">
            <table class="table" id="recentSalesTable">
              <thead><tr><th>Invoice#</th><th>Customer</th><th>Amount</th><th>Date</th><th>Status</th></tr></thead>
              <tbody id="recentSalesTbody">
                @if(isset($recentSales) && count($recentSales) > 0)
                    @foreach($recentSales as $sale)
                    <tr>
                      <td><span class="badge badge-primary" style="font-family:var(--mono)">{{ $sale->invoice_number }}</span></td>
                      <td>{{ $sale->customer ? $sale->customer->name : 'Walk-in' }}</td>
                      <td style="font-weight:600;color:var(--primary)">Rs. {{ number_format($sale->grand_total, 2) }}</td>
                      <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                      <td><span class="badge badge-success">Paid</span></td>
                    </tr>
                    @endforeach
                @else
                    <tr><td colspan="5" class="empty-cell">No sales yet</td></tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
        <div class="dash-side">
          <div class="card" id="lowStockAlertCard">
            <div class="card-header"><h3>Low Stock Alert</h3></div>
            <div id="lowStockAlertList" class="alert-list">
              @if(isset($lowStockItems) && count($lowStockItems) > 0)
                  @foreach($lowStockItems as $item)
                  <div class="alert-item">
                    <div><div class="name">{{ $item->name }}</div><div class="meta">Stock: {{ $item->stock_quantity }} | Min: {{ $item->low_stock_level }}</div></div>
                    <span class="badge badge-warning">Low</span>
                  </div>
                  @endforeach
              @else
                  <div class="no-data">No low stock items</div>
              @endif
            </div>
          </div>
          <div class="card" id="expiryAlertCard">
            <div class="card-header"><h3>Expiry Alert</h3></div>
            <div id="expiryAlertList" class="alert-list">
              @if(isset($expiringItems) && count($expiringItems) > 0)
                  @foreach($expiringItems as $item)
                  <div class="alert-item">
                    <div><div class="name">{{ $item->name }}</div><div class="meta">Expires in {{ now()->diffInDays($item->expiry_date) }} days</div></div>
                    <span class="badge badge-warning">{{ now()->diffInDays($item->expiry_date) }}d</span>
                  </div>
                  @endforeach
              @else
                  <div class="no-data">No expiry alerts</div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

</main>
@endsection
