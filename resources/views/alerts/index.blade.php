@extends('layouts.app')

@section('content')
<main class="page-content">

<!-- ALERTS -->
    <div class="page" id="page-alerts">
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
