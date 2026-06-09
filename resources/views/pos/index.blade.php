@extends('layouts.app')

@section('content')
<main class="page-content">

    <!-- DASHBOARD -->
    <div class="page" id="page-dashboard">
      <div class="stat-grid" id="dashStats"></div>
      <div class="dash-grid">
        <div class="card">
          <div class="card-header">
            <h3>Recent Sales</h3>
            <button class="btn btn-sm btn-ghost" onclick="navigate('sales')">View All</button>
          </div>
          <div class="table-wrap">
            <table class="table" id="recentSalesTable">
              <thead><tr><th>Invoice#</th><th>Customer</th><th>Amount</th><th>Date</th><th>Status</th></tr></thead>
              <tbody id="recentSalesTbody"></tbody>
            </table>
          </div>
        </div>
        <div class="dash-side">
          <div class="card" id="lowStockAlertCard">
            <div class="card-header"><h3>Low Stock Alert</h3></div>
            <div id="lowStockAlertList" class="alert-list"></div>
          </div>
          <div class="card" id="expiryAlertCard">
            <div class="card-header"><h3>Expiry Alert</h3></div>
            <div id="expiryAlertList" class="alert-list"></div>
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

          <!-- Medicine Grid -->
          <div class="card">
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
            <div id="posMedGrid" class="pos-med-grid"></div>
          </div>

          <!-- Cart -->
          <div class="card">
            <div class="card-header">
              <h3>Cart Items</h3>
              <span id="cartBadge" class="badge badge-primary">0 items</span>
            </div>
            <div class="table-wrap">
              <table class="table" id="cartTable">
                <thead><tr><th>Medicine</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
                <tbody id="cartTbody"><tr><td colspan="5" class="empty-cell">Cart is empty — click any medicine above to add</td></tr></tbody>
              </table>
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
              <div class="sum-row"><span>Subtotal</span><span id="sumSubtotal">Rs. 0.00</span></div>
              <div class="sum-row">
                <span>Discount (%)</span>
                <input type="number" id="posDiscount" class="input input-sm" value="0" min="0" max="100" style="width:70px"/>
              </div>
              <div class="sum-row">
                <span>Tax (%)</span>
                <input type="number" id="posTax" class="input input-sm" value="0" min="0" max="100" style="width:70px"/>
              </div>
              <div class="sum-row sum-total"><span>Grand Total</span><span id="sumGrandTotal">Rs. 0.00</span></div>
              <div class="sum-row">
                <span>Paid Amount</span>
                <input type="number" id="posPaid" class="input input-sm" value="0" min="0" style="width:100px"/>
              </div>
              <div class="sum-row"><span>Due Amount</span><span id="sumDue">Rs. 0.00</span></div>
              <div class="sum-row"><span>Return Amount</span><span id="sumReturn">Rs. 0.00</span></div>
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

    <!-- SALES -->
    <div class="page hidden" id="page-sales">
      <div class="card">
        <div class="card-header">
          <h3>Sales History</h3>
          <div class="header-actions">
            <input type="date" class="input input-sm" id="salesDateFilter"/>
            <input type="text" class="input input-sm" id="salesSearch" placeholder="Search customer..."/>
            <button class="btn btn-sm btn-ghost" onclick="exportSalesCSV()">Export CSV</button>
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

    <!-- MEDICINES -->
    <div class="page hidden" id="page-medicines">
      <div class="card">
        <div class="card-header">
          <h3>Medicine Inventory</h3>
          <div class="header-actions">
            <input type="text" class="input input-sm" id="medSearch" placeholder="Search medicines..."/>
            <select class="input input-sm" id="medCatFilter"><option value="">All Categories</option></select>
            <button class="btn btn-primary btn-sm" onclick="openMedModal()">+ Add Medicine</button>
          </div>
        </div>
        <div class="table-wrap">
          <table class="table">
            <thead><tr><th>Name</th><th>Generic</th><th>Category</th><th>Company</th><th>Batch</th><th>Sale Price</th><th>Stock</th><th>Expiry</th><th>Rx</th><th>Actions</th></tr></thead>
            <tbody id="medTbody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- CATEGORIES -->
    <div class="page hidden" id="page-categories">
      <div class="page-half">
        <div class="card">
          <div class="card-header"><h3 id="catFormTitle">Add Category</h3></div>
          <div class="form-body">
            <input type="hidden" id="catEditId"/>
            <div class="form-group"><label>Category Name *</label><input type="text" id="catName" class="input" placeholder="e.g. Antibiotics"/></div>
            <div class="form-group"><label>Description</label><textarea id="catDesc" class="input" rows="2" placeholder="Optional description..."></textarea></div>
            <div class="form-group"><label>Color Tag</label><input type="color" id="catColor" class="input" value="#00b4d8" style="width:60px;height:40px;padding:4px;cursor:pointer"/></div>
            <div class="form-actions">
              <button class="btn btn-primary" onclick="saveCategory()">Save Category</button>
              <button class="btn btn-ghost" onclick="resetCatForm()">Reset</button>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3>Categories</h3>
            <input type="text" class="input input-sm" id="catSearch" placeholder="Search..."/>
          </div>
          <div class="table-wrap">
            <table class="table">
              <thead><tr><th>Color</th><th>Name</th><th>Description</th><th>Medicines</th><th>Actions</th></tr></thead>
              <tbody id="catTbody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- SUPPLIERS -->
    <div class="page hidden" id="page-suppliers">
      <div class="card">
        <div class="card-header">
          <h3>Suppliers</h3>
          <div class="header-actions">
            <input type="text" class="input input-sm" id="suppSearch" placeholder="Search suppliers..."/>
            <button class="btn btn-primary btn-sm" onclick="openSuppModal()">+ Add Supplier</button>
          </div>
        </div>
        <div class="table-wrap">
          <table class="table">
            <thead><tr><th>Name</th><th>Company</th><th>Phone</th><th>Email</th><th>Address</th><th>Actions</th></tr></thead>
            <tbody id="suppTbody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- CUSTOMERS -->
    <div class="page hidden" id="page-customers">
      <div class="card">
        <div class="card-header">
          <h3>Customers</h3>
          <div class="header-actions">
            <input type="text" class="input input-sm" id="custSearch" placeholder="Search customers..."/>
            <button class="btn btn-primary btn-sm" onclick="openCustModal()">+ Add Customer</button>
          </div>
        </div>
        <div class="table-wrap">
          <table class="table">
            <thead><tr><th>Name</th><th>Phone</th><th>Email</th><th>Age</th><th>Gender</th><th>Address</th><th>Actions</th></tr></thead>
            <tbody id="custTbody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ALERTS -->
    <div class="page hidden" id="page-alerts">
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
