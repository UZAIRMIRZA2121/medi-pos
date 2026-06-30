<aside class="sidebar" id="sidebar">
  @php
      $staffPrivileges = [];
      if (session()->has('staff_id')) {
          $currentStaff = \App\Models\Staff::find(session('staff_id'));
          $staffPrivileges = $currentStaff ? ($currentStaff->privileges ?? []) : [];
      }
      
      function hasPrivilege($slug, $staffPrivileges) {
          if (!session()->has('staff_id')) return true; // Store owner has all
          return in_array($slug, $staffPrivileges);
      }
  @endphp
  <div class="sidebar-brand">
    <div class="brand-icon">
      <svg width="28" height="28" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="40" height="40" rx="10" fill="url(#medipos_grad)"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M20 28.5L18.75 27.35C14.15 23.18 11 20.35 11 16.85C11 14.02 13.22 11.8 16.05 11.8C17.65 11.8 19.18 12.55 20 13.7C20.82 12.55 22.35 11.8 23.95 11.8C26.78 11.8 29 14.02 29 16.85C29 20.35 25.85 23.18 21.25 27.36L20 28.5Z" fill="white"/>
        <path d="M12 17.5H15.5L17 14L20.5 22L22.5 17.5H28" stroke="#60A5FA" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        <defs>
          <linearGradient id="medipos_grad" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
            <stop stop-color="#3B82F6"/>
            <stop offset="1" stop-color="#8B5CF6"/>
          </linearGradient>
        </defs>
      </svg>
    </div>
    <div class="brand-text">
      <span class="brand-name" style="font-weight: 700; letter-spacing: -0.5px;">Medi<span style="color: #60A5FA;">POS</span></span>
      <span class="brand-sub">POS System</span>
    </div>
    <button class="sidebar-close" id="sidebarClose">×</button>
  </div>

  <nav class="sidebar-nav">
    @if(Auth::check() && Auth::user()->type === 'seller')
    <div class="nav-group">
      <span class="nav-group-label">Seller Portal</span>
      <a class="nav-item {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}" href="{{ route('seller.dashboard') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Dashboard
      </a>
      <a class="nav-item {{ request()->routeIs('seller.commissions') ? 'active' : '' }}" href="{{ route('seller.commissions') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M12 12h.01"/><path d="M17 12h.01"/><path d="M7 12h.01"/></svg>
        Commissions
      </a>
      <a class="nav-item {{ request()->routeIs('seller.payout') ? 'active' : '' }}" href="{{ route('seller.payout') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        Payout Settings
      </a>
    </div>
    @elseif(Auth::check() && Auth::user()->type === 'admin')
    <div class="nav-group">
        <span class="nav-group-label">Admin Portal</span>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span>Stores</span>
        </a>
        <a href="{{ route('admin.sellers.index') }}" class="nav-item {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            <span>Sellers</span>
        </a>
        <a href="{{ route('admin.payments.index') }}" class="nav-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            <span>Payments</span>
        </a>
        <a href="{{ route('admin.packages.index') }}" class="nav-item {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        Packages
      </a>
      <a href="{{ route('admin.wallets.index') }}" class="nav-item {{ request()->routeIs('admin.wallets.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
        Seller Commissions
      </a>
    </div>
    @elseif(Auth::check())
    @if(hasPrivilege('dashboard', $staffPrivileges))
    <div class="nav-group">
      <span class="nav-group-label">Overview</span>
      <a class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Dashboard
      </a>
    </div>
    @endif
    @if(hasPrivilege('pos', $staffPrivileges) || hasPrivilege('invoices', $staffPrivileges) || hasPrivilege('sales_history', $staffPrivileges) || hasPrivilege('expenses', $staffPrivileges))
    <div class="nav-group">
      <span class="nav-group-label">Sales</span>
      @if(hasPrivilege('pos', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('pos.index') ? 'active' : '' }}" href="{{ route('pos.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
        POS / Billing
      </a>
      @endif
      @if(hasPrivilege('invoices', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        Invoices
      </a>
      @endif
      @if(hasPrivilege('sales_history', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Sales History
      </a>
      @endif
      @if(hasPrivilege('expenses', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('expenses.*') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        Expenses
      </a>
      @endif
    </div>
    @endif
    @if(hasPrivilege('medicines', $staffPrivileges) || hasPrivilege('categories', $staffPrivileges) || hasPrivilege('alerts', $staffPrivileges) || hasPrivilege('purchase_orders', $staffPrivileges))
    <div class="nav-group">
      <span class="nav-group-label">Inventory</span>
      @if(hasPrivilege('medicines', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('medicines.*') ? 'active' : '' }}" href="{{ route('medicines.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 9l-7 7-7-7"/><circle cx="12" cy="5" r="3"/></svg>
        Medicines
      </a>
      @endif
      @if(hasPrivilege('categories', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
        Categories
      </a>
      @endif
      @if(hasPrivilege('alerts', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('alerts.*') ? 'active' : '' }}" href="{{ route('alerts.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        Stock & Expiry Alerts
        <span class="nav-badge" id="alertBadge">0</span>
      </a>
      @endif
      @if(hasPrivilege('purchase_orders', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('purchase_orders.*') ? 'active' : '' }}" href="{{ route('purchase_orders.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Purchase Orders
      </a>
      @endif
    </div>
    @endif
    @if(hasPrivilege('suppliers', $staffPrivileges) || hasPrivilege('customers', $staffPrivileges) || hasPrivilege('staff', $staffPrivileges))
    <div class="nav-group">
      <span class="nav-group-label">Contacts</span>
      @if(hasPrivilege('suppliers', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        Suppliers
      </a>
      @endif
      @if(hasPrivilege('customers', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Customers
      </a>
      @endif
      @if(hasPrivilege('staff', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('staff.*') ? 'active' : '' }}" href="{{ route('staff.index') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.318l8.243 4.318v7.697l-8.243 4.318-8.243-4.318V8.636L12 4.318z"></path><path d="M12 12l8.243-4.318M12 12v8.636M12 12l-8.243-4.318"></path></svg>
        Staff
      </a>
      @endif
    </div>
    @endif
    @if(hasPrivilege('settings_store', $staffPrivileges) || hasPrivilege('profile', $staffPrivileges))
    <div class="nav-group">
      <span class="nav-group-label">Settings</span>

      @if(hasPrivilege('settings_store', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('settings.store') ? 'active' : '' }}" href="{{ route('settings.store') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        Store Settings
      </a>
      @endif
      @if(hasPrivilege('profile', $staffPrivileges))
      <a class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        My Profile
      </a>
      @endif
    </div>
    @endif
    @endif
  </nav>

  <div class="sidebar-footer" style="display:flex; align-items:center; justify-content:space-between;">
    <div class="user-info">
      <div class="user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
      <div class="user-meta">
        <span class="user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
        <span class="user-role">{{ ucfirst(Auth::user()->type ?? 'Admin') }}</span>
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