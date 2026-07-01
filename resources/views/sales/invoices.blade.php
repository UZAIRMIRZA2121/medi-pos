@extends('layouts.app')

@section('content')
<main class="page-content">

<!-- INVOICES -->
    <div class="page" id="page-invoices">
      <div class="card">
        <div class="card-header">
          <h3>Invoice History</h3>
          <div style="display: flex; flex-direction: column; gap: 10px; align-items: flex-end;">
            <div class="header-actions" style="display: flex; gap: 5px; flex-wrap: wrap;">
              <input type="date" class="input input-sm" id="invoiceStartDate" onchange="renderInvoices()" title="Start Date" />
              <input type="date" class="input input-sm" id="invoiceEndDate" onchange="renderInvoices()" title="End Date" />
              <button class="btn btn-sm btn-outline" onclick="setInvoiceDateRange('thisMonth')">This Month</button>
              <button class="btn btn-sm btn-outline" onclick="setInvoiceDateRange('lastMonth')">Last Month</button>
              <input type="text" class="input input-sm" id="invoiceSearch" oninput="renderInvoices()" placeholder="Search invoice or customer..."/>
            </div>
            <div class="filter-buttons" style="display: flex; gap: 5px; flex-wrap: wrap;">
              <button class="btn btn-sm btn-primary invoice-filter-btn" id="btnFilterAll" onclick="setInvoiceFilter('all')">All</button>
              <button class="btn btn-sm btn-outline invoice-filter-btn" id="btnFilterPaid" onclick="setInvoiceFilter('paid')">Paid</button>
              <button class="btn btn-sm btn-outline invoice-filter-btn" id="btnFilterUnpaid" onclick="setInvoiceFilter('unpaid')">Unpaid</button>
              <button class="btn btn-sm btn-outline invoice-filter-btn" id="btnFilterPartial" onclick="setInvoiceFilter('partial')">Partial Paid</button>
            </div>
          </div>
        </div>
        <div class="table-wrap">
          <table class="table">
            <thead><tr><th>Invoice#</th><th>Customer</th><th>Items</th><th>Total</th><th>Paid</th><th>Due</th><th>Return</th><th>Payment</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody id="invoicesTbody"></tbody>
          </table>
        </div>
      </div>
    </div>

</main>
@endsection
