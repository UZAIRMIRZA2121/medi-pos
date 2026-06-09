<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M2 12h20"/><circle cx="12" cy="12" r="10"/></svg>
    </div>
    <div class="brand-text">
      <span class="brand-name">MediPoint</span>
      <span class="brand-sub">POS System</span>
    </div>
    <button class="sidebar-close" id="sidebarClose">×</button>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-group">
      <span class="nav-group-label">Overview</span>
      <a class="nav-item" href="{{ route('dashboard') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Dashboard
      </a>
    </div>
    <div class="nav-group">
      <span class="nav-group-label">Sales</span>
      <a class="nav-item" href="{{ route('pos.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
        POS / Billing
      </a>
      <a class="nav-item" href="{{ route('invoices.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        Invoices
      </a>
      <a class="nav-item" href="{{ route('sales.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Sales History
      </a>
    </div>
    <div class="nav-group">
      <span class="nav-group-label">Inventory</span>
      <a class="nav-item" href="{{ route('medicines.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 9l-7 7-7-7"/><circle cx="12" cy="5" r="3"/></svg>
        Medicines
      </a>
      <a class="nav-item" href="{{ route('categories.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
        Categories
      </a>
      <a class="nav-item" href="{{ route('alerts.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Stock & Expiry Alerts
        <span class="nav-badge" id="alertBadge">0</span>
      </a>
    </div>
    <div class="nav-group">
      <span class="nav-group-label">Contacts</span>
      <a class="nav-item" href="{{ route('suppliers.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Suppliers
      </a>
      <a class="nav-item" href="{{ route('customers.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Customers
      </a>
    </div>
  </nav>

  <div class="sidebar-footer" style="display:flex; align-items:center; justify-content:space-between;">
    <div class="user-info">
      <div class="user-avatar">A</div>
      <div class="user-meta">
        <span class="user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
        <span class="user-role">Pharmacist</span>
      </div>
    </div>
    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
      @csrf
      <button type="submit" class="btn btn-ghost" style="padding:8px; color:var(--danger);" title="Logout">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
          <polyline points="16 17 21 12 16 7"></polyline>
          <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
      </button>
    </form>
  </div>
</aside>