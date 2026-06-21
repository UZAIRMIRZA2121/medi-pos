@extends('layouts.app')

@section('content')
<main class="page-content">

<!-- SALES -->
    <div class="page" id="page-sales">
      <div class="card">
        <div class="card-header">
          <h3>Sales History</h3>
          <div class="header-actions" style="display: flex; gap: 5px; flex-wrap: wrap;">
            <input type="date" class="input input-sm" id="salesStartDate" onchange="renderSales()" title="Start Date" />
            <input type="date" class="input input-sm" id="salesEndDate" onchange="renderSales()" title="End Date" />
            <button class="btn btn-sm btn-outline" onclick="setSalesDateRange('thisMonth')">This Month</button>
            <button class="btn btn-sm btn-outline" onclick="setSalesDateRange('lastMonth')">Last Month</button>
            <input type="text" class="input input-sm" id="salesSearch" oninput="renderSales()" placeholder="Search customer..."/>
            <button class="btn btn-sm btn-ghost" onclick="exportSalesCSV()">Export CSV</button>
            <button class="btn btn-sm btn-primary" onclick="printSalesSummary()">Print Summary</button>
          </div>
        </div>
        <div class="table-wrap">
          <table class="table">
            <thead><tr><th>Invoice#</th><th>Customer</th><th>Items</th><th>Subtotal</th><th>Discount</th><th>Tax</th><th>Grand Total</th><th>Paid</th><th>Method</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody id="salesTbody"></tbody>
          </table>
        </div>
      </div>
    </div>

</main>
@endsection
