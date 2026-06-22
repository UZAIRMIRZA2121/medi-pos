@extends('layouts.app')

@section('content')
<main class="page-content">

<!-- ALERTS -->
    <div class="page" id="page-alerts">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Alerts Overview</h2>
        <button onclick="printAlerts()" style="background: var(--primary); color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px;">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
          Print Alerts Report
        </button>
      </div>
      <div class="alerts-grid">
        <div class="card">
          <div class="card-header"><h3 class="text-danger">Expired Medicines</h3></div>
          <div class="table-wrap">
            <table class="table">
              <thead><tr><th>Medicine</th><th>Category</th><th>Stock</th><th>Expiry</th><th>Days</th></tr></thead>
              <tbody id="expiredTbody"></tbody>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><h3 class="text-warning">Expiring Soon (30 days)</h3></div>
          <div class="table-wrap">
            <table class="table">
              <thead><tr><th>Medicine</th><th>Category</th><th>Stock</th><th>Expiry</th><th>Days Left</th></tr></thead>
              <tbody id="expiringSoonTbody"></tbody>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-header"><h3 class="text-warning">Low Stock Medicines</h3></div>
          <div class="table-wrap">
            <table class="table">
              <thead><tr><th>Medicine</th><th>Category</th><th>Stock</th><th>Rack</th><th>Supplier</th></tr></thead>
              <tbody id="lowStockTbody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

</main>
@endsection
