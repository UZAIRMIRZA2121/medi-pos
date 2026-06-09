// ============================================================
// MediPoint POS - Main Script
// ============================================================

// ============================================================
// STORAGE HELPERS
// ============================================================
const store = {
  get: (key, def = []) => { try { return JSON.parse(localStorage.getItem('mp_' + key)) ?? def; } catch { return def; } },
  set: (key, val) => localStorage.setItem('mp_' + key, JSON.stringify(val)),
};

// ============================================================
// DEMO DATA SEED
// ============================================================
function seedDemoData() {
  if (store.get('seeded', false)) return;

  const categories = [
    { id: 1, name: 'Antibiotics', desc: 'Bacterial infection medicines', color: '#ef4444' },
    { id: 2, name: 'Analgesics', desc: 'Pain relief medicines', color: '#f59e0b' },
    { id: 3, name: 'Antacids', desc: 'Stomach and acidity medicines', color: '#10b981' },
    { id: 4, name: 'Vitamins & Supplements', desc: 'Nutritional supplements', color: '#6366f1' },
    { id: 5, name: 'Antihistamines', desc: 'Allergy medicines', color: '#ec4899' },
    { id: 6, name: 'Antidiabetics', desc: 'Diabetes management', color: '#0066cc' },
    { id: 7, name: 'Cardiovascular', desc: 'Heart and BP medicines', color: '#dc2626' },
    { id: 8, name: 'Dermatology', desc: 'Skin care products', color: '#8b5cf6' },
  ];

  const suppliers = [
    { id: 1, name: 'Ahmed Ali', company: 'PharmaCo Ltd', phone: '0300-1234567', email: 'ahmed@pharmaco.pk', address: 'G-9, Islamabad', notes: 'Best for antibiotics' },
    { id: 2, name: 'Sara Khan', company: 'MedSupply Corp', phone: '0321-9876543', email: 'sara@medsupply.pk', address: 'Gulberg III, Lahore', notes: 'Fast delivery' },
    { id: 3, name: 'Zafar Iqbal', company: 'National Pharma', phone: '0333-4567890', email: 'zafar@natpharma.pk', address: 'SITE Area, Karachi', notes: 'Reliable supplier' },
  ];

  const today = new Date();
  const addDays = (d, n) => { const x = new Date(d); x.setDate(x.getDate() + n); return x.toISOString().split('T')[0]; };

  const medicines = [
    { id: 1, name: 'Amoxil 500mg', generic: 'Amoxicillin', catId: 1, company: 'GSK', batch: 'B2024001', barcode: '123456789', purchase: 120, sale: 180, stock: 5, lowStock: 10, expiry: addDays(today, 365), mfg: addDays(today, -365), supplierId: 1, rack: 'A-1', rx: 'yes', desc: 'Broad-spectrum antibiotic' },
    { id: 2, name: 'Panadol 500mg', generic: 'Paracetamol', catId: 2, company: 'GSK', batch: 'B2024002', barcode: '234567890', purchase: 20, sale: 35, stock: 200, lowStock: 20, expiry: addDays(today, 730), mfg: addDays(today, -30), supplierId: 2, rack: 'B-2', rx: 'no', desc: 'Pain and fever relief' },
    { id: 3, name: 'Flagyl 400mg', generic: 'Metronidazole', catId: 1, company: 'Pfizer', batch: 'B2024003', barcode: '345678901', purchase: 80, sale: 120, stock: 3, lowStock: 15, expiry: addDays(today, -10), mfg: addDays(today, -400), supplierId: 1, rack: 'A-2', rx: 'yes', desc: 'Antiprotozoal antibiotic' },
    { id: 4, name: 'Gaviscon Syrup', generic: 'Sodium Alginate', catId: 3, company: 'Reckitt', batch: 'B2024004', barcode: '456789012', purchase: 150, sale: 220, stock: 45, lowStock: 10, expiry: addDays(today, 500), mfg: addDays(today, -60), supplierId: 2, rack: 'C-1', rx: 'no', desc: 'Heartburn and reflux' },
    { id: 5, name: 'Centrum Adult', generic: 'Multivitamins', catId: 4, company: 'Pfizer', batch: 'B2024005', barcode: '567890123', purchase: 600, sale: 850, stock: 60, lowStock: 15, expiry: addDays(today, 600), mfg: addDays(today, -90), supplierId: 3, rack: 'D-1', rx: 'no', desc: 'Complete daily multivitamin' },
    { id: 6, name: 'Claritin 10mg', generic: 'Loratadine', catId: 5, company: 'Bayer', batch: 'B2024006', barcode: '678901234', purchase: 200, sale: 320, stock: 8, lowStock: 10, expiry: addDays(today, 15), mfg: addDays(today, -350), supplierId: 2, rack: 'E-1', rx: 'no', desc: 'Antihistamine for allergies' },
    { id: 7, name: 'Glucophage 500mg', generic: 'Metformin', catId: 6, company: 'Merck', batch: 'B2024007', barcode: '789012345', purchase: 90, sale: 140, stock: 120, lowStock: 25, expiry: addDays(today, 400), mfg: addDays(today, -50), supplierId: 3, rack: 'F-1', rx: 'yes', desc: 'Type 2 diabetes management' },
    { id: 8, name: 'Concor 5mg', generic: 'Bisoprolol', catId: 7, company: 'Merck', batch: 'B2024008', barcode: '890123456', purchase: 180, sale: 280, stock: 7, lowStock: 10, expiry: addDays(today, 20), mfg: addDays(today, -300), supplierId: 1, rack: 'G-1', rx: 'yes', desc: 'Beta-blocker for hypertension' },
    { id: 9, name: 'Betadine Solution', generic: 'Povidone-Iodine', catId: 8, company: 'Purdue', batch: 'B2024009', barcode: '901234567', purchase: 110, sale: 170, stock: 35, lowStock: 10, expiry: addDays(today, 800), mfg: addDays(today, -120), supplierId: 2, rack: 'H-1', rx: 'no', desc: 'Antiseptic solution' },
    { id: 10, name: 'Vitamin C 1000mg', generic: 'Ascorbic Acid', catId: 4, company: 'Nutrifactor', batch: 'B2024010', barcode: '012345678', purchase: 250, sale: 380, stock: 80, lowStock: 20, expiry: addDays(today, 550), mfg: addDays(today, -70), supplierId: 3, rack: 'D-2', rx: 'no', desc: 'Immunity booster' },
  ];

  const customers = [
    { id: 1, name: 'Muhammad Usman', phone: '0311-2345678', email: 'usman@email.com', age: 35, gender: 'male', address: 'Block A, DHA Lahore' },
    { id: 2, name: 'Fatima Malik', phone: '0322-3456789', email: 'fatima@email.com', age: 28, gender: 'female', address: 'Gulshan-e-Iqbal, Karachi' },
    { id: 3, name: 'Bilal Ahmed', phone: '0333-4567891', email: 'bilal@email.com', age: 42, gender: 'male', address: 'F-7, Islamabad' },
    { id: 4, name: 'Ayesha Siddiqui', phone: '0344-5678901', email: 'ayesha@email.com', age: 55, gender: 'female', address: 'Cantt, Rawalpindi' },
  ];

  // Generate demo invoices
  const invoices = [];
  const sampleItems = [
    [{ medId: 2, name: 'Panadol 500mg', qty: 3, price: 35, sub: 105 }, { medId: 5, name: 'Centrum Adult', qty: 1, price: 850, sub: 850 }],
    [{ medId: 7, name: 'Glucophage 500mg', qty: 2, price: 140, sub: 280 }, { medId: 4, name: 'Gaviscon Syrup', qty: 1, price: 220, sub: 220 }],
    [{ medId: 9, name: 'Betadine Solution', qty: 1, price: 170, sub: 170 }, { medId: 10, name: 'Vitamin C 1000mg', qty: 2, price: 380, sub: 760 }],
  ];

  for (let i = 0; i < 3; i++) {
    const d = new Date(); d.setDate(d.getDate() - i);
    const items = sampleItems[i];
    const subtotal = items.reduce((s, x) => s + x.sub, 0);
    const discount = 5;
    const tax = 0;
    const discAmt = subtotal * discount / 100;
    const grand = subtotal - discAmt;
    invoices.push({
      id: 'INV' + String(1001 + i).padStart(4, '0'),
      custId: i + 1,
      custName: customers[i].name,
      items,
      subtotal,
      discount,
      tax,
      discAmt,
      taxAmt: 0,
      grand,
      paid: grand,
      due: 0,
      ret: 0,
      payment: ['cash', 'card', 'online'][i],
      notes: '',
      date: d.toISOString(),
      cashier: 'Admin',
    });
  }

  store.set('categories', categories);
  store.set('suppliers', suppliers);
  store.set('medicines', medicines);
  store.set('customers', customers);
  store.set('invoices', invoices);
  store.set('nextInvNum', 1004);
  store.set('seeded', true);
}

// ============================================================
// STATE
// ============================================================
let cart = [];
let currentPage = 'dashboard';

// ============================================================
// NAVIGATION
// ============================================================
function navigate(page) {
  document.querySelectorAll('.page').forEach(p => p.classList.add('hidden'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

  const el = document.getElementById('page-' + page);
  if (el) el.classList.remove('hidden');

  const nav = document.querySelector(`[data-page="${page}"]`);
  if (nav) nav.classList.add('active');

  const titles = {
    dashboard: 'Dashboard', pos: 'POS / Billing', invoices: 'Invoice History',
    sales: 'Sales History', medicines: 'Medicine Inventory', categories: 'Category Management',
    suppliers: 'Supplier Management', customers: 'Customer Management', alerts: 'Stock & Expiry Alerts'
  };
  document.getElementById('pageTitle').textContent = titles[page] || page;
  currentPage = page;

  closeSidebar();
  renderPage(page);
}

function renderPage(page) {
  const r = {
    dashboard: renderDashboard,
    pos: renderPOS,
    invoices: renderInvoices,
    sales: renderSales,
    medicines: renderMedicines,
    categories: renderCategories,
    suppliers: renderSuppliers,
    customers: renderCustomers,
    alerts: renderAlerts,
  };
  if (r[page]) r[page]();
}

// ============================================================
// SIDEBAR TOGGLE
// ============================================================
function openSidebar() {
  document.getElementById('sidebar').classList.add('open');
  document.getElementById('overlay').classList.add('visible');
}
function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('overlay').classList.remove('visible');
}

// ============================================================
// THEME
// ============================================================
function initTheme() {
  const saved = localStorage.getItem('mp_theme') || 'light';
  document.documentElement.setAttribute('data-theme', saved);
  updateThemeIcon(saved);
}
function toggleTheme() {
  const cur = document.documentElement.getAttribute('data-theme');
  const next = cur === 'light' ? 'dark' : 'light';
  document.documentElement.setAttribute('data-theme', next);
  localStorage.setItem('mp_theme', next);
  updateThemeIcon(next);
}
function updateThemeIcon(theme) {
  const icon = document.getElementById('themeIcon');
  if (theme === 'dark') {
    icon.innerHTML = '<path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>';
  } else {
    icon.innerHTML = '<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>';
  }
}

// ============================================================
// TOAST
// ============================================================
function toast(msg, type = 'success') {
  const icons = { success: '✓', warning: '⚠', danger: '✕', info: 'ℹ' };
  const el = document.createElement('div');
  el.className = `toast ${type}`;
  el.innerHTML = `<span class="toast-icon">${icons[type] || '✓'}</span><span class="toast-msg">${msg}</span><button class="toast-close" onclick="this.parentElement.remove()">×</button>`;
  document.getElementById('toastContainer').appendChild(el);
  setTimeout(() => { el.style.animation = 'fadeOut 0.3s ease forwards'; setTimeout(() => el.remove(), 300); }, 3500);
}

// ============================================================
// CONFIRM MODAL
// ============================================================
let confirmCallback = null;
function confirmDelete(msg, cb) {
  document.getElementById('confirmMsg').textContent = msg || 'Are you sure?';
  confirmCallback = cb;
  document.getElementById('confirmModal').classList.remove('hidden');
  document.getElementById('confirmOkBtn').onclick = () => { cb(); closeConfirmModal(); };
}
function closeConfirmModal() { document.getElementById('confirmModal').classList.add('hidden'); confirmCallback = null; }

// ============================================================
// HELPERS
// ============================================================
function fmtCur(n) { return 'Rs. ' + Number(n).toLocaleString('en-PK', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
function fmtDate(d) { if (!d) return '-'; return new Date(d).toLocaleDateString('en-GB'); }
function fmtDateTime(d) { if (!d) return '-'; return new Date(d).toLocaleString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }); }
function daysDiff(dateStr) { return Math.ceil((new Date(dateStr) - new Date()) / 86400000); }
function isExpired(d) { return new Date(d) < new Date(); }
function isLowStock(m) { return m.stock <= m.lowStock; }
function getCategory(id) { return store.get('categories').find(c => c.id == id) || {}; }
function getSupplier(id) { return store.get('suppliers').find(s => s.id == id) || {}; }
function getCustomer(id) { return store.get('customers').find(c => c.id == id) || {}; }
function nextId(arr) { return arr.length ? Math.max(...arr.map(x => x.id)) + 1 : 1; }
function svgIcon(path, size = 13) { return `<svg width="${size}" height="${size}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">${path}</svg>`; }

const EDIT_SVG = svgIcon('<path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>');
const DEL_SVG = svgIcon('<polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/>');
const VIEW_SVG = svgIcon('<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>');

// ============================================================
// ALERT BADGE UPDATE
// ============================================================
function updateAlertBadge() {
  const meds = store.get('medicines');
  const count = meds.filter(m => isExpired(m.expiry) || isLowStock(m)).length;
  const badge = document.getElementById('alertBadge');
  badge.textContent = count;
  badge.style.display = count > 0 ? 'inline-flex' : 'none';
}

// ============================================================
// DASHBOARD
// ============================================================
function renderDashboard() {
  const meds = store.get('medicines');
  const cats = store.get('categories');
  const invoices = store.get('invoices');
  const today = new Date().toDateString();

  const todaySales = invoices.filter(i => new Date(i.date).toDateString() === today);
  const todayTotal = todaySales.reduce((s, i) => s + i.grand, 0);
  const lowStock = meds.filter(m => isLowStock(m));
  const expired = meds.filter(m => isExpired(m.expiry));

  const stats = [
    { label: 'Total Medicines', value: meds.length, icon: '<circle cx="12" cy="12" r="5"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/>', bg: '#e6f0ff', color: '#0066cc' },
    { label: 'Categories', value: cats.length, icon: '<path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/>', bg: '#ede9fe', color: '#6366f1' },
    { label: 'Low Stock', value: lowStock.length, icon: '<line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/>', bg: '#fef3c7', color: '#f59e0b' },
    { label: 'Expired', value: expired.length, icon: '<path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>', bg: '#fee2e2', color: '#ef4444' },
    { label: 'Today Sales', value: fmtCur(todayTotal), icon: '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>', bg: '#d1fae5', color: '#10b981' },
    { label: 'Total Invoices', value: invoices.length, icon: '<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>', bg: '#fce7f3', color: '#ec4899' },
  ];

  document.getElementById('dashStats').innerHTML = stats.map(s =>
    `<div class="stat-card">
      <div class="stat-icon" style="background:${s.bg};color:${s.color}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">${s.icon}</svg>
      </div>
      <div>
        <div class="stat-value">${s.value}</div>
        <div class="stat-label">${s.label}</div>
      </div>
    </div>`
  ).join('');

  // Recent sales
  const recent = [...invoices].sort((a, b) => new Date(b.date) - new Date(a.date)).slice(0, 8);
  document.getElementById('recentSalesTbody').innerHTML = recent.length ?
    recent.map(i => `<tr>
      <td><span class="badge badge-primary" style="font-family:var(--mono)">${i.id}</span></td>
      <td>${i.custName}</td>
      <td style="font-weight:600;color:var(--primary)">${fmtCur(i.grand)}</td>
      <td>${fmtDate(i.date)}</td>
      <td><span class="badge badge-success">Paid</span></td>
    </tr>`).join('') :
    '<tr><td colspan="5" class="empty-cell">No sales yet</td></tr>';

  // Low stock alert
  document.getElementById('lowStockAlertList').innerHTML = lowStock.length ?
    lowStock.slice(0, 5).map(m => `<div class="alert-item">
      <div><div class="name">${m.name}</div><div class="meta">Stock: ${m.stock} | Min: ${m.lowStock}</div></div>
      <span class="badge badge-warning">Low</span>
    </div>`).join('') :
    '<div class="no-data">No low stock items</div>';

  // Expiry alert
  const expiring = meds.filter(m => {
    const d = daysDiff(m.expiry);
    return d >= 0 && d <= 30;
  }).concat(expired).slice(0, 5);
  document.getElementById('expiryAlertList').innerHTML = expiring.length ?
    expiring.map(m => {
      const d = daysDiff(m.expiry);
      const exp = d < 0;
      return `<div class="alert-item">
        <div><div class="name">${m.name}</div><div class="meta">${exp ? 'Expired ' + Math.abs(d) + ' days ago' : 'Expires in ' + d + ' days'}</div></div>
        <span class="badge ${exp ? 'badge-danger' : 'badge-warning'}">${exp ? 'Expired' : d + 'd'}</span>
      </div>`;
    }).join('') :
    '<div class="no-data">No expiry alerts</div>';
}

// ============================================================
// POS
// ============================================================
function renderPOS() {
  // Populate customer dropdown
  const custSel = document.getElementById('posCustomer');
  custSel.innerHTML = '<option value="">Walk-in Customer</option>' +
    store.get('customers').map(c => `<option value="${c.id}">${c.name} — ${c.phone}</option>`).join('');

  // Populate category tabs
  const cats = store.get('categories');
  const tabs = document.getElementById('posCatTabs');
  tabs.innerHTML = `<button class="cat-tab active" data-cat="" onclick="filterPosCat(this,'')">All</button>` +
    cats.map(c => `<button class="cat-tab" data-cat="${c.id}" onclick="filterPosCat(this,${c.id})" style="--cat-color:${c.color}">${c.name}</button>`).join('');

  // Populate category select (dropdown)
  const catSel = document.getElementById('posCatFilter');
  catSel.innerHTML = '<option value="">All Categories</option>' +
    cats.map(c => `<option value="${c.id}">${c.name}</option>`).join('');

  renderMedGrid();
  renderCart();
}

// State for POS filters
let posFilter = { q: '', catId: '', view: 'grid' };

function filterPosCat(btn, catId) {
  posFilter.catId = catId;
  document.querySelectorAll('.cat-tab').forEach(t => t.classList.remove('active'));
  btn.classList.add('active');
  const sel = document.getElementById('posCatFilter');
  if (sel) sel.value = catId;
  renderMedGrid();
}

function setPosView(v) {
  posFilter.view = v;
  document.getElementById('viewGrid').classList.toggle('active', v === 'grid');
  document.getElementById('viewList').classList.toggle('active', v === 'list');
  const grid = document.getElementById('posMedGrid');
  grid.classList.toggle('list-view', v === 'list');
  renderMedGrid();
}

function clearPosSearch() {
  document.getElementById('posSearch').value = '';
  posFilter.q = '';
  document.getElementById('posSearchClear').classList.add('hidden');
  renderMedGrid();
}

function renderMedGrid() {
  let meds = store.get('medicines');
  const q = posFilter.q.toLowerCase();
  if (q) meds = meds.filter(m =>
    m.name.toLowerCase().includes(q) ||
    (m.generic || '').toLowerCase().includes(q) ||
    (m.barcode || '').includes(q) ||
    (m.company || '').toLowerCase().includes(q)
  );
  if (posFilter.catId) meds = meds.filter(m => m.catId == posFilter.catId);

  const countEl = document.getElementById('posMedCount');
  countEl.textContent = q || posFilter.catId ? `${meds.length} result${meds.length !== 1 ? 's' : ''}` : `${meds.length} medicines`;

  const grid = document.getElementById('posMedGrid');
  grid.classList.toggle('list-view', posFilter.view === 'list');

  if (!meds.length) {
    grid.innerHTML = `<div class="pos-no-results">
      <div class="pos-no-results-icon">🔍</div>
      <div style="font-weight:600;margin-bottom:4px">No medicines found</div>
      <div style="font-size:12px">Try a different search or category</div>
    </div>`;
    return;
  }

  if (posFilter.view === 'list') {
    grid.innerHTML = meds.map(m => buildMedRow(m)).join('');
  } else {
    grid.innerHTML = meds.map(m => buildMedCard(m)).join('');
  }
}

function buildMedCard(m) {
  const exp = isExpired(m.expiry);
  const low = isLowStock(m);
  const oos = m.stock <= 0 || exp;
  const cat = getCategory(m.catId);
  const inCart = cart.find(c => c.medId == m.id);
  const cartQty = inCart ? inCart.qty : 0;

  let stockBg = '#d1fae5'; let stockColor = '#065f46';
  if (oos) { stockBg = '#fee2e2'; stockColor = '#991b1b'; }
  else if (low) { stockBg = '#fef3c7'; stockColor = '#92400e'; }

  return `<div class="med-card${oos ? ' out-of-stock' : ''}${inCart ? ' in-cart' : ''}" onclick="addToCart(${m.id})">
    ${inCart ? `<div class="med-card-incart">${cartQty}</div>` : ''}
    ${exp ? '<span class="med-card-badge" style="background:#fee2e2;color:#991b1b">Expired</span>' :
      low && !oos ? '<span class="med-card-badge" style="background:#fef3c7;color:#92400e">Low</span>' : ''}
    ${cat.name ? `<div class="med-card-cat" style="color:${cat.color || 'var(--text-muted)'}">${cat.name}</div>` : ''}
    <div class="med-card-name">${m.name}</div>
    ${m.generic ? `<div class="med-card-generic">${m.generic}</div>` : ''}
    <div class="med-card-footer">
      <span class="med-card-price">${fmtCur(m.sale)}</span>
      <span class="med-card-stock" style="background:${stockBg};color:${stockColor}">${oos ? 'Out' : m.stock}</span>
    </div>
  </div>`;
}

function buildMedRow(m) {
  const exp = isExpired(m.expiry);
  const low = isLowStock(m);
  const oos = m.stock <= 0 || exp;
  const cat = getCategory(m.catId);
  const inCart = cart.find(c => c.medId == m.id);

  return `<div class="med-row${oos ? ' out-of-stock' : ''}${inCart ? ' in-cart' : ''}" onclick="addToCart(${m.id})">
    <div class="med-row-info">
      <div class="med-row-name">${m.name} ${inCart ? `<span class="badge badge-success" style="font-size:10px">In cart ×${inCart.qty}</span>` : ''}
        ${exp ? '<span class="badge badge-danger" style="font-size:10px">Expired</span>' : ''}
      </div>
      <div class="med-row-meta">
        ${m.generic ? m.generic + ' · ' : ''}
        ${cat.name ? `<span style="color:${cat.color || 'inherit'}">${cat.name}</span> · ` : ''}
        Stock: <strong>${m.stock}</strong>
        ${low && !oos ? ' · <span style="color:var(--warning)">Low stock</span>' : ''}
      </div>
    </div>
    <div class="med-row-price">${fmtCur(m.sale)}</div>
  </div>`;
}

// POS Search
let posSearchTimeout = null;
document.addEventListener('DOMContentLoaded', () => {
  const posSearchEl = document.getElementById('posSearch');
  if (posSearchEl) {
    posSearchEl.addEventListener('input', function () {
      posFilter.q = this.value;
      const clearBtn = document.getElementById('posSearchClear');
      if (clearBtn) clearBtn.classList.toggle('hidden', !this.value);
      clearTimeout(posSearchTimeout);
      posSearchTimeout = setTimeout(renderMedGrid, 150);
    });
  }

  const catSel = document.getElementById('posCatFilter');
  if (catSel) {
    catSel.addEventListener('change', function () {
      posFilter.catId = this.value;
      // Sync tab highlight
      document.querySelectorAll('.cat-tab').forEach(t => {
        t.classList.toggle('active', t.dataset.cat == this.value || (!this.value && t.dataset.cat === ''));
      });
      renderMedGrid();
    });
  }

  // Live summary updates
  ['posDiscount', 'posTax', 'posPaid'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', renderCartSummary);
  });
});

function addToCart(medId) {
  const med = store.get('medicines').find(m => m.id == medId);
  if (!med) return;
  if (isExpired(med.expiry)) { toast('Cannot sell expired medicine!', 'danger'); return; }
  if (med.stock <= 0) { toast('Out of stock!', 'danger'); return; }

  const existing = cart.find(c => c.medId == medId);
  if (existing) {
    if (existing.qty >= med.stock) { toast('Not enough stock!', 'warning'); return; }
    existing.qty++;
    existing.sub = existing.qty * existing.price;
  } else {
    cart.push({ medId: med.id, name: med.name, price: med.sale, qty: 1, sub: med.sale, maxStock: med.stock });
  }
  renderCart();
  renderMedGrid();
  toast(`${med.name} added`, 'success');
}

function changeQty(medId, delta) {
  const item = cart.find(c => c.medId == medId);
  if (!item) return;
  const newQty = item.qty + delta;
  if (newQty <= 0) { removeFromCart(medId); return; }
  if (newQty > item.maxStock) { toast('Not enough stock!', 'warning'); return; }
  item.qty = newQty;
  item.sub = item.qty * item.price;
  renderCart();
  renderMedGrid();
}

function removeFromCart(medId) {
  cart = cart.filter(c => c.medId != medId);
  renderCart();
  renderMedGrid();
}

function clearCart() {
  cart = [];
  renderCart();
  renderMedGrid();
  document.getElementById('posDiscount').value = 0;
  document.getElementById('posTax').value = 0;
  document.getElementById('posPaid').value = 0;
  document.getElementById('posNotes').value = '';
}

function renderCart() {
  const totalQty = cart.reduce((s, c) => s + c.qty, 0);
  const badge = document.getElementById('cartBadge');
  if (badge) badge.textContent = totalQty + ' item' + (totalQty !== 1 ? 's' : '');

  const tbody = document.getElementById('cartTbody');
  if (!cart.length) {
    tbody.innerHTML = '<tr><td colspan="5" class="empty-cell">Cart is empty — click any medicine to add</td></tr>';
    renderCartSummary();
    return;
  }
  tbody.innerHTML = cart.map(item =>
    `<tr>
      <td>
        <div style="font-weight:500">${item.name}</div>
      </td>
      <td>${fmtCur(item.price)}</td>
      <td>
        <div class="qty-control">
          <button class="qty-btn" onclick="changeQty(${item.medId}, -1)">−</button>
          <span class="qty-display">${item.qty}</span>
          <button class="qty-btn" onclick="changeQty(${item.medId}, 1)">+</button>
        </div>
      </td>
      <td style="font-weight:600;color:var(--primary)">${fmtCur(item.sub)}</td>
      <td><button class="action-btn del" onclick="removeFromCart(${item.medId})">${DEL_SVG}</button></td>
    </tr>`
  ).join('');
  renderCartSummary();
}

function renderCartSummary() {
  const subtotal = cart.reduce((s, c) => s + c.sub, 0);
  const discount = parseFloat(document.getElementById('posDiscount')?.value || 0);
  const tax = parseFloat(document.getElementById('posTax')?.value || 0);
  const paid = parseFloat(document.getElementById('posPaid')?.value || 0);

  const discAmt = subtotal * discount / 100;
  const taxAmt = (subtotal - discAmt) * tax / 100;
  const grand = subtotal - discAmt + taxAmt;
  const due = Math.max(0, grand - paid);
  const ret = Math.max(0, paid - grand);

  document.getElementById('sumItems').textContent = cart.reduce((s, c) => s + c.qty, 0);
  document.getElementById('sumSubtotal').textContent = fmtCur(subtotal);
  document.getElementById('sumGrandTotal').textContent = fmtCur(grand);
  document.getElementById('sumDue').textContent = fmtCur(due);
  document.getElementById('sumReturn').textContent = fmtCur(ret);
}

function checkout() {
  if (!cart.length) { toast('Cart is empty!', 'warning'); return; }

  const subtotal = cart.reduce((s, c) => s + c.sub, 0);
  const discount = parseFloat(document.getElementById('posDiscount').value || 0);
  const tax = parseFloat(document.getElementById('posTax').value || 0);
  const paid = parseFloat(document.getElementById('posPaid').value || 0);
  const discAmt = subtotal * discount / 100;
  const taxAmt = (subtotal - discAmt) * tax / 100;
  const grand = subtotal - discAmt + taxAmt;
  const due = Math.max(0, grand - paid);
  const ret = Math.max(0, paid - grand);

  const custId = document.getElementById('posCustomer').value;
  const cust = custId ? getCustomer(custId) : null;
  const payment = document.getElementById('posPayment').value;
  const notes = document.getElementById('posNotes').value;

  const invNum = store.get('nextInvNum', 1004);
  const invId = 'INV' + String(invNum).padStart(4, '0');

  const invoice = {
    id: invId,
    custId: custId || null,
    custName: cust ? cust.name : 'Walk-in Customer',
    items: cart.map(c => ({ ...c })),
    subtotal, discount, tax, discAmt, taxAmt, grand, paid, due, ret,
    payment, notes,
    date: new Date().toISOString(),
    cashier: 'Admin',
  };

  // Update stock
  const meds = store.get('medicines');
  cart.forEach(item => {
    const m = meds.find(x => x.id == item.medId);
    if (m) m.stock -= item.qty;
  });
  store.set('medicines', meds);

  // Save invoice
  const invoices = store.get('invoices');
  invoices.push(invoice);
  store.set('invoices', invoices);
  store.set('nextInvNum', invNum + 1);

  clearCart();
  updateAlertBadge();
  toast(`Invoice ${invId} generated successfully!`, 'success');
  showInvoiceModal(invoice);
}

// ============================================================
// INVOICE MODAL
// ============================================================
function showInvoiceModal(invoice) {
  document.getElementById('invoicePreview').innerHTML = buildInvoiceHTML(invoice);
  document.getElementById('invoiceModal').classList.remove('hidden');
}
function closeInvoiceModal() { document.getElementById('invoiceModal').classList.add('hidden'); }

// Thermal receipt CSS — 80mm roll width (~302px usable)
const THERMAL_CSS = `
  @import url('https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=DM+Sans:wght@400;500;700&display=swap');
  * { box-sizing: border-box; margin: 0; padding: 0; }
  @page { size: 80mm auto; margin: 4mm 3mm; }
  body { background: #fff; }
  .receipt {
    width: 76mm;
    font-family: 'DM Mono', 'Courier New', monospace;
    font-size: 11px;
    color: #000;
    background: #fff;
    padding: 0;
    line-height: 1.5;
  }
  .r-center { text-align: center; }
  .r-logo {
    width: 42px; height: 42px;
    background: #000;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 6px;
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
  }
  .r-store-name {
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
  }
  .r-store-sub { font-size: 9.5px; color: #444; line-height: 1.6; }
  .r-divider { border: none; border-top: 1px dashed #999; margin: 6px 0; }
  .r-divider-solid { border: none; border-top: 1px solid #000; margin: 5px 0; }
  .r-divider-double { border: none; border-top: 2px solid #000; margin: 5px 0; }
  .r-row { display: flex; justify-content: space-between; font-size: 10.5px; padding: 1px 0; }
  .r-row .label { color: #555; }
  .r-row .val { font-weight: 500; }
  .r-inv-num { font-size: 12px; font-weight: 700; letter-spacing: 1px; }
  /* Items table */
  .r-items { width: 100%; border-collapse: collapse; margin: 4px 0; }
  .r-items thead tr { border-bottom: 1px solid #000; border-top: 1px solid #000; }
  .r-items th {
    font-size: 9.5px;
    font-weight: 700;
    padding: 3px 2px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-family: 'DM Sans', sans-serif;
  }
  .r-items th:last-child, .r-items td:last-child { text-align: right; }
  .r-items th:nth-child(2), .r-items td:nth-child(2) { text-align: center; }
  .r-items th:nth-child(3), .r-items td:nth-child(3) { text-align: right; }
  .r-items td {
    font-size: 10px;
    padding: 3px 2px;
    vertical-align: top;
    border-bottom: 1px dashed #ddd;
  }
  .r-items tbody tr:last-child td { border-bottom: none; }
  .r-item-name { font-size: 10.5px; font-weight: 500; line-height: 1.3; }
  /* Totals */
  .r-totals { width: 100%; font-size: 10.5px; margin-top: 2px; }
  .r-totals td { padding: 2px 0; }
  .r-totals td:last-child { text-align: right; font-weight: 500; }
  .r-grand { font-size: 13px; font-weight: 700; font-family: 'DM Sans', sans-serif; }
  .r-grand td:last-child { font-size: 13px; font-weight: 700; }
  /* Paid / Due */
  .r-paid { font-size: 11px; }
  .r-due { color: #c00; font-weight: 700; }
  .r-ret { color: #080; font-weight: 700; }
  /* Notes */
  .r-notes { font-size: 9.5px; color: #444; border-left: 2px solid #999; padding-left: 5px; margin: 4px 0; }
  /* Footer */
  .r-footer { text-align: center; font-size: 9.5px; color: #555; margin-top: 4px; line-height: 1.7; }
  .r-footer .r-thanks { font-family: 'DM Sans', sans-serif; font-size: 11px; font-weight: 700; color: #000; }
  .r-barcode { font-family: 'DM Mono', monospace; font-size: 9px; letter-spacing: 2px; color: #888; }
  @media print {
    @page { size: 80mm auto; margin: 3mm; }
    body { margin: 0; }
  }
`;

function buildInvoiceHTML(inv) {
  // Build item rows — wrap long name to second line
  const itemRows = inv.items.map(it => `
    <tr>
      <td><div class="r-item-name">${it.name}</div></td>
      <td style="text-align:center">${it.qty}</td>
      <td style="text-align:right">${it.price.toFixed(0)}</td>
      <td style="text-align:right">${it.sub.toFixed(0)}</td>
    </tr>`).join('');

  const custPhone = inv.custId ? (getCustomer(inv.custId).phone || '') : '';

  return `<div class="receipt" id="invoicePrintArea">

    <!-- Header -->
    <div class="r-center">
      <div class="r-logo">M</div>
      <div class="r-store-name">MediPoint Pharmacy</div>
      <div class="r-store-sub">
        Shop #12, Main Market<br>
        Faisalabad, Punjab, Pakistan<br>
        Ph: 041-1234567
      </div>
    </div>

    <hr class="r-divider-solid"/>

    <!-- Invoice meta -->
    <div class="r-row"><span class="label">Invoice#</span><span class="val r-inv-num">${inv.id}</span></div>
    <div class="r-row"><span class="label">Date</span><span class="val">${fmtDateTime(inv.date)}</span></div>
    <div class="r-row"><span class="label">Cashier</span><span class="val">${inv.cashier}</span></div>
    <div class="r-row"><span class="label">Payment</span><span class="val" style="text-transform:capitalize">${inv.payment}</span></div>

    <hr class="r-divider"/>

    <!-- Customer -->
    <div class="r-row"><span class="label">Customer</span><span class="val">${inv.custName}</span></div>
    ${custPhone ? `<div class="r-row"><span class="label">Phone</span><span class="val">${custPhone}</span></div>` : ''}

    <hr class="r-divider-solid"/>

    <!-- Items -->
    <table class="r-items">
      <thead>
        <tr>
          <th style="width:42%">Item</th>
          <th style="width:10%;text-align:center">Qty</th>
          <th style="width:22%;text-align:right">Price</th>
          <th style="width:26%;text-align:right">Amt</th>
        </tr>
      </thead>
      <tbody>${itemRows}</tbody>
    </table>

    <hr class="r-divider-solid"/>

    <!-- Totals -->
    <table class="r-totals">
      <tr><td>Subtotal</td><td>${fmtCur(inv.subtotal)}</td></tr>
      ${inv.discount > 0 ? `<tr><td>Discount (${inv.discount}%)</td><td>- ${fmtCur(inv.discAmt)}</td></tr>` : ''}
      ${inv.tax > 0 ? `<tr><td>Tax (${inv.tax}%)</td><td>+ ${fmtCur(inv.taxAmt)}</td></tr>` : ''}
    </table>

    <hr class="r-divider-double"/>

    <table class="r-totals">
      <tr class="r-grand"><td>GRAND TOTAL</td><td>${fmtCur(inv.grand)}</td></tr>
    </table>

    <hr class="r-divider"/>

    <table class="r-totals">
      <tr class="r-paid"><td>Paid (${inv.payment})</td><td>${fmtCur(inv.paid)}</td></tr>
      ${inv.due > 0 ? `<tr class="r-due"><td>Due Amount</td><td>${fmtCur(inv.due)}</td></tr>` : ''}
      ${inv.ret > 0 ? `<tr class="r-ret"><td>Return</td><td>${fmtCur(inv.ret)}</td></tr>` : ''}
    </table>

    ${inv.notes ? `<hr class="r-divider"/><div class="r-notes"><strong>Note:</strong> ${inv.notes}</div>` : ''}

    <hr class="r-divider"/>

    <!-- Footer -->
    <div class="r-footer">
      <div class="r-thanks">*** Thank You! ***</div>
      Get well soon. Visit again.<br>
      Keep medicines away from children.<br>
      Store as directed on packaging.<br>
      <br>
      <span class="r-barcode">${inv.id}</span>
    </div>

    <div style="height:12px"></div>
  </div>`;
}

function printInvoice() {
  const content = document.getElementById('invoicePrintArea').outerHTML;
  const win = window.open('', '_blank', 'width=340,height=700');
  win.document.write(`<!DOCTYPE html><html><head><title>Receipt — ${document.getElementById('invoicePrintArea')?.querySelector?.('.r-inv-num')?.textContent || 'Invoice'}</title><style>${THERMAL_CSS}</style></head><body>${content}</body></html>`);
  win.document.close();
  setTimeout(() => win.print(), 400);
}

// ============================================================
// INVOICES PAGE
// ============================================================
function renderInvoices() {
  const q = (document.getElementById('invoiceSearch')?.value || '').toLowerCase();
  const list = store.get('invoices').filter(i =>
    !q || i.id.toLowerCase().includes(q) || i.custName.toLowerCase().includes(q)
  ).sort((a, b) => new Date(b.date) - new Date(a.date));

  document.getElementById('invoicesTbody').innerHTML = list.length ?
    list.map(i => `<tr>
      <td><span class="badge badge-primary" style="font-family:var(--mono)">${i.id}</span></td>
      <td>${i.custName}</td>
      <td>${i.items.length}</td>
      <td style="font-weight:600">${fmtCur(i.grand)}</td>
      <td style="color:var(--success)">${fmtCur(i.paid)}</td>
      <td style="color:${i.due > 0 ? 'var(--danger)' : 'var(--text-muted)'}">${fmtCur(i.due)}</td>
      <td><span class="badge badge-gray" style="text-transform:capitalize">${i.payment}</span></td>
      <td>${fmtDateTime(i.date)}</td>
      <td>
        <button class="action-btn view" onclick="viewInvoice('${i.id}')" title="View">${VIEW_SVG}</button>
        <button class="action-btn del" onclick="deleteInvoice('${i.id}')" title="Delete">${DEL_SVG}</button>
      </td>
    </tr>`).join('') :
    '<tr><td colspan="9" class="empty-cell">No invoices found</td></tr>';
}

function viewInvoice(invId) {
  const inv = store.get('invoices').find(i => i.id === invId);
  if (inv) showInvoiceModal(inv);
}

function deleteInvoice(invId) {
  confirmDelete('Delete invoice ' + invId + '? This cannot be undone.', () => {
    let invoices = store.get('invoices').filter(i => i.id !== invId);
    store.set('invoices', invoices);
    toast('Invoice deleted', 'danger');
    renderInvoices();
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const invSearch = document.getElementById('invoiceSearch');
  if (invSearch) invSearch.addEventListener('input', renderInvoices);
});

// ============================================================
// SALES PAGE
// ============================================================
function renderSales() {
  const q = (document.getElementById('salesSearch')?.value || '').toLowerCase();
  const dateFilter = document.getElementById('salesDateFilter')?.value;
  let list = store.get('invoices');
  if (q) list = list.filter(i => i.custName.toLowerCase().includes(q));
  if (dateFilter) list = list.filter(i => i.date.startsWith(dateFilter));
  list.sort((a, b) => new Date(b.date) - new Date(a.date));

  document.getElementById('salesTbody').innerHTML = list.length ?
    list.map(i => `<tr>
      <td><span class="badge badge-primary" style="font-family:var(--mono)">${i.id}</span></td>
      <td>${i.custName}</td>
      <td>${i.items.reduce((s, x) => s + x.qty, 0)}</td>
      <td>${fmtCur(i.subtotal)}</td>
      <td>${i.discount}%</td>
      <td>${i.tax}%</td>
      <td style="font-weight:700;color:var(--primary)">${fmtCur(i.grand)}</td>
      <td>${fmtCur(i.paid)}</td>
      <td><span class="badge badge-gray" style="text-transform:capitalize">${i.payment}</span></td>
      <td>${fmtDateTime(i.date)}</td>
      <td>
        <button class="action-btn view" onclick="viewInvoice('${i.id}')">${VIEW_SVG}</button>
      </td>
    </tr>`).join('') :
    '<tr><td colspan="11" class="empty-cell">No sales found</td></tr>';
}

function exportSalesCSV() {
  const list = store.get('invoices');
  const rows = [['Invoice#', 'Customer', 'Grand Total', 'Paid', 'Due', 'Payment', 'Date']];
  list.forEach(i => rows.push([i.id, i.custName, i.grand, i.paid, i.due, i.payment, fmtDateTime(i.date)]));
  const csv = rows.map(r => r.join(',')).join('\n');
  const a = document.createElement('a');
  a.href = 'data:text/csv,' + encodeURIComponent(csv);
  a.download = 'sales_export.csv';
  a.click();
  toast('Sales exported as CSV', 'success');
}

document.addEventListener('DOMContentLoaded', () => {
  const ss = document.getElementById('salesSearch');
  if (ss) ss.addEventListener('input', renderSales);
  const sd = document.getElementById('salesDateFilter');
  if (sd) sd.addEventListener('input', renderSales);
});

// ============================================================
// MEDICINES
// ============================================================
function renderMedicines() {
  const q = (document.getElementById('medSearch')?.value || '').toLowerCase();
  const catF = document.getElementById('medCatFilter')?.value;

  // Populate category filter
  const catSel = document.getElementById('medCatFilter');
  const prevVal = catSel.value;
  catSel.innerHTML = '<option value="">All Categories</option>' +
    store.get('categories').map(c => `<option value="${c.id}" ${prevVal == c.id ? 'selected' : ''}>${c.name}</option>`).join('');

  let meds = store.get('medicines');
  if (q) meds = meds.filter(m => m.name.toLowerCase().includes(q) || (m.generic || '').toLowerCase().includes(q) || (m.barcode || '').includes(q));
  if (catF) meds = meds.filter(m => m.catId == catF);

  document.getElementById('medTbody').innerHTML = meds.length ?
    meds.map(m => {
      const exp = isExpired(m.expiry);
      const low = isLowStock(m);
      const cat = getCategory(m.catId);
      const d = daysDiff(m.expiry);
      return `<tr class="${exp ? 'row-expired' : low ? 'row-lowstock' : ''}">
        <td>
          <div style="font-weight:500">${m.name}</div>
          ${m.barcode ? `<div style="font-size:11px;color:var(--text-muted);font-family:var(--mono)">${m.barcode}</div>` : ''}
        </td>
        <td>${m.generic || '-'}</td>
        <td>${cat.name ? `<span class="badge" style="background:${cat.color}22;color:${cat.color}">${cat.name}</span>` : '-'}</td>
        <td>${m.company || '-'}</td>
        <td style="font-family:var(--mono);font-size:12px">${m.batch || '-'}</td>
        <td style="font-weight:600">${fmtCur(m.sale)}</td>
        <td>
          <span class="badge ${low ? 'badge-warning' : m.stock === 0 ? 'badge-danger' : 'badge-success'}">${m.stock}</span>
        </td>
        <td>
          <span class="badge ${exp ? 'badge-danger' : d <= 30 ? 'badge-warning' : 'badge-success'}">${fmtDate(m.expiry)}</span>
        </td>
        <td>${m.rx === 'yes' ? '<span class="badge badge-info">Rx</span>' : '<span class="badge badge-gray">OTC</span>'}</td>
        <td>
          <button class="action-btn edit" onclick="openMedModal(${m.id})" title="Edit">${EDIT_SVG}</button>
          <button class="action-btn del" onclick="deleteMedicine(${m.id})" title="Delete">${DEL_SVG}</button>
        </td>
      </tr>`;
    }).join('') :
    '<tr><td colspan="10" class="empty-cell">No medicines found</td></tr>';
}

function openMedModal(id) {
  const cats = store.get('categories');
  const supps = store.get('suppliers');
  document.getElementById('medCat').innerHTML = '<option value="">Select category</option>' + cats.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
  document.getElementById('medSupplier').innerHTML = '<option value="">Select supplier</option>' + supps.map(s => `<option value="${s.id}">${s.name}</option>`).join('');

  if (id) {
    const m = store.get('medicines').find(x => x.id == id);
    if (!m) return;
    document.getElementById('medModalTitle').textContent = 'Edit Medicine';
    document.getElementById('medId').value = m.id;
    document.getElementById('medName').value = m.name;
    document.getElementById('medGeneric').value = m.generic || '';
    document.getElementById('medCat').value = m.catId || '';
    document.getElementById('medCompany').value = m.company || '';
    document.getElementById('medBatch').value = m.batch || '';
    document.getElementById('medBarcode').value = m.barcode || '';
    document.getElementById('medPurchase').value = m.purchase || '';
    document.getElementById('medSale').value = m.sale;
    document.getElementById('medStock').value = m.stock;
    document.getElementById('medLowStock').value = m.lowStock || 10;
    document.getElementById('medExpiry').value = m.expiry;
    document.getElementById('medMfg').value = m.mfg || '';
    document.getElementById('medSupplier').value = m.supplierId || '';
    document.getElementById('medRack').value = m.rack || '';
    document.getElementById('medRx').value = m.rx || 'no';
    document.getElementById('medDesc').value = m.desc || '';
  } else {
    document.getElementById('medModalTitle').textContent = 'Add Medicine';
    document.getElementById('medId').value = '';
    ['medName','medGeneric','medCompany','medBatch','medBarcode','medPurchase','medSale','medStock','medExpiry','medMfg','medRack','medDesc'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('medLowStock').value = 10;
    document.getElementById('medRx').value = 'no';
  }
  document.getElementById('medModal').classList.remove('hidden');
}
function closeMedModal() { document.getElementById('medModal').classList.add('hidden'); }

function saveMedicine() {
  const name = document.getElementById('medName').value.trim();
  const sale = parseFloat(document.getElementById('medSale').value);
  const stock = parseInt(document.getElementById('medStock').value);
  const expiry = document.getElementById('medExpiry').value;
  if (!name || isNaN(sale) || isNaN(stock) || !expiry) { toast('Fill required fields!', 'warning'); return; }

  const meds = store.get('medicines');
  const editId = document.getElementById('medId').value;
  const med = {
    name, sale, stock, expiry,
    id: editId ? parseInt(editId) : nextId(meds),
    generic: document.getElementById('medGeneric').value.trim(),
    catId: parseInt(document.getElementById('medCat').value) || null,
    company: document.getElementById('medCompany').value.trim(),
    batch: document.getElementById('medBatch').value.trim(),
    barcode: document.getElementById('medBarcode').value.trim(),
    purchase: parseFloat(document.getElementById('medPurchase').value) || 0,
    lowStock: parseInt(document.getElementById('medLowStock').value) || 10,
    mfg: document.getElementById('medMfg').value,
    supplierId: parseInt(document.getElementById('medSupplier').value) || null,
    rack: document.getElementById('medRack').value.trim(),
    rx: document.getElementById('medRx').value,
    desc: document.getElementById('medDesc').value.trim(),
  };

  if (editId) {
    const idx = meds.findIndex(x => x.id == editId);
    if (idx > -1) meds[idx] = med;
    toast('Medicine updated!', 'success');
  } else {
    meds.push(med);
    toast('Medicine added!', 'success');
  }
  store.set('medicines', meds);
  closeMedModal();
  renderMedicines();
  updateAlertBadge();
}

function deleteMedicine(id) {
  const med = store.get('medicines').find(m => m.id == id);
  confirmDelete(`Delete "${med?.name}"?`, () => {
    store.set('medicines', store.get('medicines').filter(m => m.id != id));
    toast('Medicine deleted', 'danger');
    renderMedicines();
    updateAlertBadge();
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const ms = document.getElementById('medSearch');
  if (ms) ms.addEventListener('input', renderMedicines);
  const mf = document.getElementById('medCatFilter');
  if (mf) mf.addEventListener('change', renderMedicines);
});

// ============================================================
// CATEGORIES
// ============================================================
function renderCategories() {
  const q = (document.getElementById('catSearch')?.value || '').toLowerCase();
  const meds = store.get('medicines');
  let cats = store.get('categories');
  if (q) cats = cats.filter(c => c.name.toLowerCase().includes(q));

  document.getElementById('catTbody').innerHTML = cats.length ?
    cats.map(c => {
      const count = meds.filter(m => m.catId == c.id).length;
      return `<tr>
        <td><span class="color-dot" style="background:${c.color}"></span></td>
        <td style="font-weight:500">${c.name}</td>
        <td>${c.desc || '-'}</td>
        <td><span class="badge badge-primary">${count}</span></td>
        <td>
          <button class="action-btn edit" onclick="editCategory(${c.id})">${EDIT_SVG}</button>
          <button class="action-btn del" onclick="deleteCategory(${c.id})">${DEL_SVG}</button>
        </td>
      </tr>`;
    }).join('') :
    '<tr><td colspan="5" class="empty-cell">No categories found</td></tr>';
}

function saveCategory() {
  const name = document.getElementById('catName').value.trim();
  if (!name) { toast('Category name required!', 'warning'); return; }
  const cats = store.get('categories');
  const editId = document.getElementById('catEditId').value;
  const cat = {
    name,
    id: editId ? parseInt(editId) : nextId(cats),
    desc: document.getElementById('catDesc').value.trim(),
    color: document.getElementById('catColor').value,
  };
  if (editId) {
    const idx = cats.findIndex(c => c.id == editId);
    if (idx > -1) cats[idx] = cat;
    toast('Category updated!', 'success');
  } else {
    cats.push(cat);
    toast('Category added!', 'success');
  }
  store.set('categories', cats);
  resetCatForm();
  renderCategories();
}

function editCategory(id) {
  const c = store.get('categories').find(x => x.id == id);
  if (!c) return;
  document.getElementById('catFormTitle').textContent = 'Edit Category';
  document.getElementById('catEditId').value = c.id;
  document.getElementById('catName').value = c.name;
  document.getElementById('catDesc').value = c.desc || '';
  document.getElementById('catColor').value = c.color || '#00b4d8';
}

function deleteCategory(id) {
  const cat = store.get('categories').find(c => c.id == id);
  confirmDelete(`Delete "${cat?.name}"?`, () => {
    store.set('categories', store.get('categories').filter(c => c.id != id));
    toast('Category deleted', 'danger');
    renderCategories();
  });
}

function resetCatForm() {
  document.getElementById('catFormTitle').textContent = 'Add Category';
  document.getElementById('catEditId').value = '';
  document.getElementById('catName').value = '';
  document.getElementById('catDesc').value = '';
  document.getElementById('catColor').value = '#00b4d8';
}

document.addEventListener('DOMContentLoaded', () => {
  const cs = document.getElementById('catSearch');
  if (cs) cs.addEventListener('input', renderCategories);
});

// ============================================================
// SUPPLIERS
// ============================================================
function renderSuppliers() {
  const q = (document.getElementById('suppSearch')?.value || '').toLowerCase();
  let list = store.get('suppliers');
  if (q) list = list.filter(s => s.name.toLowerCase().includes(q) || (s.company || '').toLowerCase().includes(q));

  document.getElementById('suppTbody').innerHTML = list.length ?
    list.map(s => `<tr>
      <td style="font-weight:500">${s.name}</td>
      <td>${s.company || '-'}</td>
      <td>${s.phone || '-'}</td>
      <td>${s.email || '-'}</td>
      <td>${s.address || '-'}</td>
      <td>
        <button class="action-btn edit" onclick="openSuppModal(${s.id})">${EDIT_SVG}</button>
        <button class="action-btn del" onclick="deleteSupplier(${s.id})">${DEL_SVG}</button>
      </td>
    </tr>`).join('') :
    '<tr><td colspan="6" class="empty-cell">No suppliers found</td></tr>';
}

function openSuppModal(id) {
  if (id) {
    const s = store.get('suppliers').find(x => x.id == id);
    if (!s) return;
    document.getElementById('suppModalTitle').textContent = 'Edit Supplier';
    document.getElementById('suppId').value = s.id;
    document.getElementById('suppName').value = s.name;
    document.getElementById('suppCompany').value = s.company || '';
    document.getElementById('suppPhone').value = s.phone || '';
    document.getElementById('suppEmail').value = s.email || '';
    document.getElementById('suppAddress').value = s.address || '';
    document.getElementById('suppNotes').value = s.notes || '';
  } else {
    document.getElementById('suppModalTitle').textContent = 'Add Supplier';
    document.getElementById('suppId').value = '';
    ['suppName','suppCompany','suppPhone','suppEmail','suppAddress','suppNotes'].forEach(id => document.getElementById(id).value = '');
  }
  document.getElementById('suppModal').classList.remove('hidden');
}
function closeSuppModal() { document.getElementById('suppModal').classList.add('hidden'); }

function saveSupplier() {
  const name = document.getElementById('suppName').value.trim();
  const phone = document.getElementById('suppPhone').value.trim();
  if (!name || !phone) { toast('Name and phone required!', 'warning'); return; }
  const list = store.get('suppliers');
  const editId = document.getElementById('suppId').value;
  const s = {
    name, phone,
    id: editId ? parseInt(editId) : nextId(list),
    company: document.getElementById('suppCompany').value.trim(),
    email: document.getElementById('suppEmail').value.trim(),
    address: document.getElementById('suppAddress').value.trim(),
    notes: document.getElementById('suppNotes').value.trim(),
  };
  if (editId) {
    const idx = list.findIndex(x => x.id == editId);
    if (idx > -1) list[idx] = s;
    toast('Supplier updated!', 'success');
  } else {
    list.push(s);
    toast('Supplier added!', 'success');
  }
  store.set('suppliers', list);
  closeSuppModal();
  renderSuppliers();
}

function deleteSupplier(id) {
  const s = store.get('suppliers').find(x => x.id == id);
  confirmDelete(`Delete supplier "${s?.name}"?`, () => {
    store.set('suppliers', store.get('suppliers').filter(x => x.id != id));
    toast('Supplier deleted', 'danger');
    renderSuppliers();
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const ss = document.getElementById('suppSearch');
  if (ss) ss.addEventListener('input', renderSuppliers);
});

// ============================================================
// CUSTOMERS
// ============================================================
function renderCustomers() {
  const q = (document.getElementById('custSearch')?.value || '').toLowerCase();
  let list = store.get('customers');
  if (q) list = list.filter(c => c.name.toLowerCase().includes(q) || (c.phone || '').includes(q));

  document.getElementById('custTbody').innerHTML = list.length ?
    list.map(c => `<tr>
      <td style="font-weight:500">${c.name}</td>
      <td>${c.phone}</td>
      <td>${c.email || '-'}</td>
      <td>${c.age || '-'}</td>
      <td><span class="badge badge-gray" style="text-transform:capitalize">${c.gender || '-'}</span></td>
      <td>${c.address || '-'}</td>
      <td>
        <button class="action-btn edit" onclick="openCustModal(${c.id})">${EDIT_SVG}</button>
        <button class="action-btn del" onclick="deleteCustomer(${c.id})">${DEL_SVG}</button>
      </td>
    </tr>`).join('') :
    '<tr><td colspan="7" class="empty-cell">No customers found</td></tr>';
}

function openCustModal(id) {
  if (id) {
    const c = store.get('customers').find(x => x.id == id);
    if (!c) return;
    document.getElementById('custModalTitle').textContent = 'Edit Customer';
    document.getElementById('custId').value = c.id;
    document.getElementById('custName').value = c.name;
    document.getElementById('custPhone').value = c.phone;
    document.getElementById('custEmail').value = c.email || '';
    document.getElementById('custAge').value = c.age || '';
    document.getElementById('custGender').value = c.gender || 'male';
    document.getElementById('custAddress').value = c.address || '';
  } else {
    document.getElementById('custModalTitle').textContent = 'Add Customer';
    document.getElementById('custId').value = '';
    ['custName','custPhone','custEmail','custAge','custAddress'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('custGender').value = 'male';
  }
  document.getElementById('custModal').classList.remove('hidden');
}
function closeCustModal() { document.getElementById('custModal').classList.add('hidden'); }

function saveCustomer() {
  const name = document.getElementById('custName').value.trim();
  const phone = document.getElementById('custPhone').value.trim();
  if (!name || !phone) { toast('Name and phone required!', 'warning'); return; }
  const list = store.get('customers');
  const editId = document.getElementById('custId').value;
  const c = {
    name, phone,
    id: editId ? parseInt(editId) : nextId(list),
    email: document.getElementById('custEmail').value.trim(),
    age: parseInt(document.getElementById('custAge').value) || null,
    gender: document.getElementById('custGender').value,
    address: document.getElementById('custAddress').value.trim(),
  };
  if (editId) {
    const idx = list.findIndex(x => x.id == editId);
    if (idx > -1) list[idx] = c;
    toast('Customer updated!', 'success');
  } else {
    list.push(c);
    toast('Customer added!', 'success');
  }
  store.set('customers', list);
  closeCustModal();
  renderCustomers();
}

function deleteCustomer(id) {
  const c = store.get('customers').find(x => x.id == id);
  confirmDelete(`Delete customer "${c?.name}"?`, () => {
    store.set('customers', store.get('customers').filter(x => x.id != id));
    toast('Customer deleted', 'danger');
    renderCustomers();
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const cs = document.getElementById('custSearch');
  if (cs) cs.addEventListener('input', renderCustomers);
});

// ============================================================
// ALERTS
// ============================================================
function renderAlerts() {
  const meds = store.get('medicines');
  const cats = store.get('categories');
  const catName = id => (cats.find(c => c.id == id) || {}).name || '-';

  const expired = meds.filter(m => isExpired(m.expiry));
  const expiringSoon = meds.filter(m => { const d = daysDiff(m.expiry); return d >= 0 && d <= 30; });
  const lowStock = meds.filter(m => isLowStock(m));

  document.getElementById('expiredTbody').innerHTML = expired.length ?
    expired.map(m => `<tr>
      <td style="font-weight:500">${m.name}</td>
      <td>${catName(m.catId)}</td>
      <td>${m.stock}</td>
      <td>${fmtDate(m.expiry)}</td>
      <td><span class="badge badge-danger">${Math.abs(daysDiff(m.expiry))} days ago</span></td>
    </tr>`).join('') :
    '<tr><td colspan="5" class="empty-cell">No expired medicines</td></tr>';

  document.getElementById('expiringSoonTbody').innerHTML = expiringSoon.length ?
    expiringSoon.map(m => `<tr>
      <td style="font-weight:500">${m.name}</td>
      <td>${catName(m.catId)}</td>
      <td>${m.stock}</td>
      <td>${fmtDate(m.expiry)}</td>
      <td><span class="badge badge-warning">${daysDiff(m.expiry)} days</span></td>
    </tr>`).join('') :
    '<tr><td colspan="5" class="empty-cell">No medicines expiring soon</td></tr>';

  document.getElementById('lowStockTbody').innerHTML = lowStock.length ?
    lowStock.map(m => `<tr>
      <td style="font-weight:500">${m.name}</td>
      <td>${catName(m.catId)}</td>
      <td><span class="badge badge-warning">${m.stock} / ${m.lowStock}</span></td>
      <td>${m.rack || '-'}</td>
      <td>${(getSupplier(m.supplierId) || {}).name || '-'}</td>
    </tr>`).join('') :
    '<tr><td colspan="5" class="empty-cell">No low stock medicines</td></tr>';
}

// ============================================================
// INIT
// ============================================================
document.addEventListener('DOMContentLoaded', () => {
  seedDemoData();
  initTheme();

  // Date display
  const tick = () => {
    document.getElementById('topbarDate').textContent = new Date().toLocaleString('en-GB', {
      weekday: 'short', day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'
    });
  };
  tick();
  setInterval(tick, 60000);

  // Navigation
  document.querySelectorAll('.nav-item[data-page]').forEach(el => {
    el.addEventListener('click', () => navigate(el.dataset.page));
  });

  // Theme toggle
  document.getElementById('themeToggle').addEventListener('click', toggleTheme);

  // Menu
  document.getElementById('menuBtn').addEventListener('click', openSidebar);
  document.getElementById('sidebarClose').addEventListener('click', closeSidebar);
  document.getElementById('overlay').addEventListener('click', closeSidebar);

  updateAlertBadge();
  navigate('dashboard');
});