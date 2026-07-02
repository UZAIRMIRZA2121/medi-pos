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
            <div class="stat-value">PKR {{ number_format($todaySalesSum ?? 0, 2) }}</div>
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
                      <td style="font-weight:600;color:var(--primary)">PKR {{ number_format($sale->grand_total, 2) }}</td>
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

    <!-- POS -->
    <div class="page hidden" id="page-pos">
      <div class="pos-layout">

        <!-- LEFT: Medicine browser + Cart -->
        <div class="pos-left">

          <!-- Search & Filter bar -->
          <div class="card pos-search-card">
            <div class="pos-topbar">
              <div class="pos-search-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="posSearch" class="pos-search-input" placeholder="Search medicine by name, generic or barcode..."/>
                <button class="pos-search-clear hidden" id="posSearchClear" onclick="clearPosSearch()">×</button>
              </div>
              <select id="posCatFilter" class="input input-sm" style="width:160px;flex-shrink:0">
                <option value="">All Categories</option>
              </select>
            </div>
            <div class="pos-cat-tabs" id="posCatTabs"></div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
            <!-- Medicine Grid -->
            <div class="card" style="display: flex; flex-direction: column; height: 100%;">
              <div class="pos-med-header">
                <span id="posMedCount" class="pos-med-count">All medicines</span>
                <div class="pos-view-toggle">
                  <button class="view-btn active" id="viewGrid" onclick="setPosView('grid')" title="Grid view">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                  </button>
                  <button class="view-btn" id="viewList" onclick="setPosView('list')" title="List view">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                  </button>
                </div>
              </div>
              <div id="posMedGrid" class="pos-med-grid" style="flex: 1; overflow-y: auto; max-height: 400px;"></div>
            </div>

            <!-- Cart -->
            <div class="card" style="display: flex; flex-direction: column; height: 100%;">
              <div class="card-header">
                <h3>Cart Items</h3>
                <span id="cartBadge" class="badge badge-primary">0 items</span>
              </div>
              <div class="table-wrap" style="flex: 1; overflow-y: auto; max-height: 400px;">
                <table class="table" id="cartTable">
                  <thead><tr><th>Medicine</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
                  <tbody id="cartTbody"><tr><td colspan="5" class="empty-cell">Cart is empty — click any medicine above to add</td></tr></tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Notes + Customer row -->
          <div class="card">
            <div class="pos-bottom-row">
              <div class="form-group" style="flex:1">
                <label>Customer</label>
                <select id="posCustomer" class="input">
                  <option value="">Walk-in Customer</option>
                </select>
              </div>
              <div class="form-group" style="flex:1">
                <label>Payment Method</label>
                <select id="posPayment" class="input">
                  <option value="cash">Cash</option>
                  <option value="card">Card</option>
                  <option value="online">Online Payment</option>
                </select>
              </div>
              <div class="form-group" style="flex:2">
                <label>Invoice Notes</label>
                <input type="text" id="posNotes" class="input" placeholder="Optional notes..."/>
              </div>
            </div>
          </div>

        </div>

        <!-- RIGHT: Bill Summary -->
        <div class="pos-right">
          <div class="card pos-summary">
            <div class="card-header"><h3>Bill Summary</h3></div>
            <div class="summary-rows">
              <div class="sum-row"><span>Total Items</span><span id="sumItems">0</span></div>
              <div class="sum-row"><span>Subtotal</span><span id="sumSubtotal">PKR 0.00</span></div>
              <div class="sum-row">
                <span>Discount (%)</span>
                <input type="number" id="posDiscount" class="input input-sm" value="0" min="0" max="100" style="width:70px"/>
              </div>
              <div class="sum-row">
                <span>Tax (%)</span>
                <input type="number" id="posTax" class="input input-sm" value="0" min="0" max="100" style="width:70px"/>
              </div>
              <div class="sum-row sum-total"><span>Grand Total</span><span id="sumGrandTotal">PKR 0.00</span></div>
              <div class="sum-row">
                <span>Paid Amount</span>
                <input type="number" id="posPaid" class="input input-sm" value="0" min="0" style="width:100px"/>
              </div>
              <div class="sum-row"><span>Due Amount</span><span id="sumDue">PKR 0.00</span></div>
              <div class="sum-row"><span>Return Amount</span><span id="sumReturn">PKR 0.00</span></div>
            </div>
            <button class="btn btn-primary btn-full" id="checkoutBtn" onclick="checkout()">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
              Generate Invoice
            </button>
            <button class="btn btn-ghost btn-full" onclick="clearCart()">Clear Cart</button>
          </div>
        </div>
      </div>
    </div>

    <!-- INVOICES -->
    <div class="page hidden" id="page-invoices">
      <div class="card">
        <div class="card-header">
          <h3>Invoice History</h3>
          <div class="header-actions">
            <input type="text" class="input input-sm" id="invoiceSearch" placeholder="Search invoice or customer..."/>
          </div>
        </div>
        <div class="table-wrap">
          <table class="table">
            <thead><tr><th>Invoice#</th><th>Customer</th><th>Items</th><th>Total</th><th>Paid</th><th>Due</th><th>Payment</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody id="invoicesTbody"></tbody>
          </table>
        </div>
      </div>
    </div>



  </main>
@endsection
