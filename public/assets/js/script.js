// ============================================================
// MediPos POS - Main Script
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


async function api(url, method = 'GET', body = null) {
    const opts = {
        method,
        cache: 'no-store',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    };
    if (body) opts.body = JSON.stringify(body);
    const res = await fetch(url, opts);
    if (!res.ok) {
        let errMsg = 'API Error';
        try {
            const errData = await res.json();
            errMsg = errData.message || errMsg;
        } catch(err) {}
        throw new Error(errMsg);
    }
    if (method !== 'DELETE') return await res.json();
    return true;
}

async function syncData() {
    try {
        const [cats, meds, supps, custs, sales] = await Promise.all([
            api('/api/categories'),
            api('/api/medicines'),
            api('/api/suppliers'),
            api('/api/customers'),
            api('/api/sales')
        ]);
        
        // Map DB columns to frontend expected fields if necessary
        // The frontend expects: catId instead of category_id, supplierId instead of supplier_id
        const mappedMeds = meds.map(m => ({...m, catId: m.category_id, supplierId: m.supplier_id, stock: m.stock_quantity, lowStock: m.low_stock_level, sale: m.sale_price, purchase: m.purchase_price, expiry: m.expiry_date, mfg: m.mfg_date, generic: m.generic_name }));
        
        store.set('categories', cats);
        store.set('medicines', mappedMeds);
        store.set('suppliers', supps);
        store.set('customers', custs);
        store.set('invoices', sales);
        
        if (document.getElementById('page-categories')) renderCategories();
        if (document.getElementById('page-medicines')) renderMedicines();
        if (document.getElementById('page-suppliers')) renderSuppliers();
        if (document.getElementById('page-customers')) renderCustomers();
        if (document.getElementById('page-alerts')) renderAlerts();
        if (document.getElementById('page-sales')) renderSales();
        if (document.getElementById('page-invoices')) renderInvoices();
        if (document.getElementById('page-pos')) renderPOS();

    } catch(e) {
        console.error('Failed to sync data', e);
        toast('Database connection error', 'danger');
    }
}

// ============================================================
// STATE
// ============================================================
let cart = [];
let currentPage = 'dashboard';

// ============================================================
// NAVIGATION
// ============================================================
function navigate(page) { window.location.href = '/' + page; }

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
function fmtCur(n) { return 'PKR ' + Number(n).toLocaleString('en-PK', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
function fmtDate(d) { if (!d) return '-'; return new Date(d).toLocaleDateString('en-GB'); }
function fmtDateTime(d) { if (!d) return '-'; return new Date(d).toLocaleString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true }).toUpperCase(); }
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
  // Now rendered dynamically via Laravel Blade from DashboardController
  // The frontend script no longer overwrites the dashboard HTML.
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
    cart.push({ medId: med.id, name: med.name, price: parseFloat(med.sale), qty: 1, sub: parseFloat(med.sale), maxStock: parseFloat(med.stock) });
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

async function checkout() {
  if (!cart.length) { toast('Cart is empty!', 'warning'); return; }

  const discount = parseFloat(document.getElementById('posDiscount').value || 0);
  const tax = parseFloat(document.getElementById('posTax').value || 0);
  const paid = parseFloat(document.getElementById('posPaid').value || 0);
  const custId = document.getElementById('posCustomer').value || null;
  const payment = document.getElementById('posPayment').value;
  const notes = document.getElementById('posNotes').value;

  const payload = {
      customer_id: custId,
      discount_percent: discount,
      tax_percent: tax,
      paid_amount: paid,
      payment_method: payment,
      notes: notes,
      items: cart.map(c => ({
          medicine_id: c.medId,
          quantity: c.qty,
          unit_price: c.price
      }))
  };

  try {
      const btn = document.getElementById('checkoutBtn');
      const origText = btn.innerHTML;
      btn.innerHTML = 'Processing...';
      btn.disabled = true;

      const invoice = await api('/pos/checkout', 'POST', payload);
      
      clearCart();
      await syncData();
      
      toast(`Invoice generated successfully!`, 'success');
      showInvoiceModal(invoice);

      if (document.getElementById('autoPrint')?.checked) {
          setTimeout(printInvoice, 300);
      }

      btn.innerHTML = origText;
      btn.disabled = false;
  } catch(e) {
      toast(e.message, 'danger');
      const btn = document.getElementById('checkoutBtn');
      btn.innerHTML = 'Generate Invoice';
      btn.disabled = false;
  }
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
  * { box-sizing: border-box; margin: 0; padding: 0; }
  @page { size: 80mm auto; margin: 4mm 3mm; }
  body { background: #fff; }
  .receipt {
    width: 76mm;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 13px;
    font-weight: normal;
    color: #000;
    background: #fff;
    padding: 0;
    line-height: 1.5;
  }
  .r-center { text-align: center; }
  .r-logo {
    width: 42px; height: 42px;
    background: #000 !important;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 6px;
    color: #fff !important;
    font-size: 18px;
    font-weight: normal;
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }
  .r-store-name {
    font-size: 24px;
    font-weight: normal;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
  }
  .r-store-sub { font-size: 13px; font-weight: normal; color: #000; line-height: 1.6; }
  .r-divider { border: none; border-top: 1px dashed #000; margin: 6px 0; }
  .r-divider-solid { border: none; border-top: 1px solid #000; margin: 5px 0; }
  .r-divider-double { border: none; border-top: 2px solid #000; margin: 5px 0; }
  .r-row { display: flex; justify-content: space-between; font-size: 13px; font-weight: normal; padding: 1px 0; }
  .r-row .label { color: #000; }
  .r-row .val { font-weight: normal; }
  .r-inv-num { font-size: 14px; font-weight: normal; letter-spacing: 1px; }
  /* Items table */
  .r-items { width: 100%; border-collapse: collapse; margin: 4px 0; }
  .r-items thead tr { border-bottom: 1px solid #000; border-top: 1px solid #000; }
  .r-items th {
    font-size: 12px;
    font-weight: normal;
    padding: 3px 2px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
  .r-items th:last-child, .r-items td:last-child { text-align: right; }
  .r-items th:nth-child(2), .r-items td:nth-child(2) { text-align: center; }
  .r-items th:nth-child(3), .r-items td:nth-child(3) { text-align: right; }
  .r-items td {
    font-size: 13px;
    font-weight: normal;
    padding: 3px 2px;
    vertical-align: top;
    border-bottom: 1px dashed #666;
  }
  .r-items tbody tr:last-child td { border-bottom: none; }
  .r-item-name { font-size: 13px; font-weight: normal; line-height: 1.3; }
  /* Totals */
  .r-totals { width: 100%; font-size: 13px; font-weight: normal; margin-top: 2px; }
  .r-totals td { padding: 2px 0; }
  .r-totals td:last-child { text-align: right; font-weight: normal; }
  .r-grand { font-size: 16px; font-weight: normal; }
  .r-grand td:last-child { font-size: 16px; font-weight: normal; }
  /* Paid / Due */
  .r-paid { font-size: 14px; font-weight: normal; }
  .r-due { color: #000; font-weight: normal; }
  .r-ret { color: #000; font-weight: normal; }
  /* Notes */
  .r-notes { font-size: 12px; font-weight: normal; color: #000; border-left: 2px solid #000; padding-left: 5px; margin: 4px 0; }
  /* Footer */
  .r-footer { text-align: center; font-size: 13px; font-weight: normal; color: #000; margin-top: 4px; line-height: 1.7; }
  .r-footer .r-thanks { font-size: 10px; font-weight: bold; color: #000; }
  .r-barcode { font-family: 'Courier New', Courier, monospace; font-size: 12px; font-weight: normal; letter-spacing: 2px; color: #000; }
  @media print {
    @page { size: 80mm auto; margin: 3mm; }
    body { margin: 0; font-smooth: never; -webkit-font-smoothing: none; }
  }
`;

function buildInvoiceHTML(inv) {
  // Build item rows — wrap long name to second line
  const itemRows = inv.items.map(it => `
    <tr>
      <td><div class="r-item-name">${it.name}</div></td>
      <td style="text-align:center">${it.qty}</td>
      <td style="text-align:right">${parseFloat(it.price).toFixed(0)}</td>
      <td style="text-align:right">${parseFloat(it.sub).toFixed(0)}</td>
    </tr>`).join('');

  const custPhone = inv.custId ? (getCustomer(inv.custId).phone || '') : '';

  const sName = window.printSettings?.name || 'MediPos Pharmacy';
  const sDesc = (window.printSettings?.desc || "Shop #12, Main Market").replace(/\\n/g, '<br>');
  const sAddress = (window.printSettings?.address || "Faisalabad, Punjab, Pakistan\\nPh: 041-1234567").replace(/\\n/g, '<br>');
  const sHeading = window.printSettings?.heading || 'INVOICE';
 const sFooter = (window.printSettings?.footer || "Thank You!\nGet Well Soon.").replace(/\n/g, '<br>');
  const sLogo = window.printSettings?.logo ? `<img src="${window.printSettings.logo}" style="max-height:40px; margin-bottom: 5px;">` : `<div class="r-logo">${sName.charAt(0)}</div>`;

  return `<div class="receipt" id="invoicePrintArea">

    <!-- Header -->
    <div class="r-center">
      ${sLogo}
      <div class="r-store-name">${sName}</div>
      <div class="r-store-sub">
        ${sDesc}
        ${sDesc && sAddress ? '<br>' : ''}
        ${sAddress}
      </div>
      <div style="font-weight:bold; font-size:14px; margin-top:5px;">${sHeading}</div>
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
      <div class="r-thanks">${sFooter}</div>
      <div style="margin-top: 12px; padding-top: 8px; border-top: 1px dotted #999; font-size: 11px; color: #444;">
        Developed with &hearts; by <strong>Uzair Mirza</strong><br>
       <span style="font-size: 14px; color: #000;">0308-6452242</span>
      </div>
    </div>

    <div style="height:12px"></div>
  </div>`;
}

function printInvoice() {
  const content = document.getElementById('invoicePrintArea').outerHTML;
  const win = window.open('', '_blank', 'width=340,height=700');
  win.document.write(`<!DOCTYPE html><html><head><title>Receipt — ${document.getElementById('invoicePrintArea')?.querySelector?.('.r-inv-num')?.textContent || 'Invoice'}</title><style>${THERMAL_CSS}</style></head><body>${content}</body></html>`);
  win.document.close();
  setTimeout(() => win.print(), 800);
}

// ============================================================
// INVOICES PAGE
// ============================================================
function setInvoiceDateRange(type) {
  const d = new Date();
  let start, end;
  if (type === 'thisMonth') {
    start = new Date(d.getFullYear(), d.getMonth(), 1);
    end = new Date(d.getFullYear(), d.getMonth() + 1, 0);
  } else if (type === 'lastMonth') {
    start = new Date(d.getFullYear(), d.getMonth() - 1, 1);
    end = new Date(d.getFullYear(), d.getMonth(), 0);
  }
  
  const formatYMD = (date) => {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${y}-${m}-${day}`;
  };
  
  if (document.getElementById('invoiceStartDate')) {
    document.getElementById('invoiceStartDate').value = formatYMD(start);
    document.getElementById('invoiceEndDate').value = formatYMD(end);
    renderInvoices();
  }
}

function renderInvoices() {
  const q = (document.getElementById('invoiceSearch')?.value || '').toLowerCase();
  const startStr = document.getElementById('invoiceStartDate')?.value;
  const endStr = document.getElementById('invoiceEndDate')?.value;
  
  const startD = startStr ? new Date(startStr) : null;
  if (startD) startD.setHours(0, 0, 0, 0);
  const endD = endStr ? new Date(endStr) : null;
  if (endD) endD.setHours(23, 59, 59, 999);

  const list = store.get('invoices').filter(i => {
    const iDate = new Date(i.date);
    let matchDate = true;
    if (startD && iDate < startD) matchDate = false;
    if (endD && iDate > endD) matchDate = false;
    
    let matchText = !q || i.id.toLowerCase().includes(q) || i.custName.toLowerCase().includes(q);
    return matchDate && matchText;
  }).sort((a, b) => new Date(b.date) - new Date(a.date));

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
function setSalesDateRange(type) {
  const d = new Date();
  let start, end;
  if (type === 'thisMonth') {
    start = new Date(d.getFullYear(), d.getMonth(), 1);
    end = new Date(d.getFullYear(), d.getMonth() + 1, 0);
  } else if (type === 'lastMonth') {
    start = new Date(d.getFullYear(), d.getMonth() - 1, 1);
    end = new Date(d.getFullYear(), d.getMonth(), 0);
  }
  
  const formatYMD = (date) => {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${y}-${m}-${day}`;
  };
  
  if (document.getElementById('salesStartDate')) {
    document.getElementById('salesStartDate').value = formatYMD(start);
    document.getElementById('salesEndDate').value = formatYMD(end);
    renderSales();
  }
}

function renderSales() {
  const q = (document.getElementById('salesSearch')?.value || '').toLowerCase();
  const startStr = document.getElementById('salesStartDate')?.value;
  const endStr = document.getElementById('salesEndDate')?.value;
  
  const startD = startStr ? new Date(startStr) : null;
  if (startD) startD.setHours(0, 0, 0, 0);
  const endD = endStr ? new Date(endStr) : null;
  if (endD) endD.setHours(23, 59, 59, 999);

  let list = store.get('invoices');
  if (q) list = list.filter(i => i.custName.toLowerCase().includes(q) || i.id.toLowerCase().includes(q));
  
  list = list.filter(i => {
    const iDate = new Date(i.date);
    let matchDate = true;
    if (startD && iDate < startD) matchDate = false;
    if (endD && iDate > endD) matchDate = false;
    return matchDate;
  });

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

async function printSalesSummary() {
  const startStr = document.getElementById('salesStartDate')?.value;
  const endStr = document.getElementById('salesEndDate')?.value;
  
  const startD = startStr ? new Date(startStr) : null;
  if (startD) startD.setHours(0, 0, 0, 0);
  const endD = endStr ? new Date(endStr) : null;
  if (endD) endD.setHours(23, 59, 59, 999);

  // Filter Sales
  let sales = store.get('invoices');
  sales = sales.filter(i => {
    const iDate = new Date(i.date);
    let matchDate = true;
    if (startD && iDate < startD) matchDate = false;
    if (endD && iDate > endD) matchDate = false;
    return matchDate;
  });

  const allMeds = store.get('medicines');
  let totalSale = 0;
  let totalCostOfGoods = 0;
  const medsSold = {};

  sales.forEach(sale => {
    totalSale += Number(sale.grand || 0);
    
    // We also need to factor in discounts and tax into profit, but for exact profit, 
    // it's easier to calculate total purchase cost of items sold, and subtract from final revenue.
    sale.items.forEach(item => {
      if (!medsSold[item.name]) medsSold[item.name] = 0;
      const qty = Number(item.qty || 0);
      medsSold[item.name] += qty;
      
      const med = allMeds.find(m => m.id == item.medId);
      if (med && med.purchase) {
        totalCostOfGoods += Number(med.purchase) * qty;
      }
    });
  });

  // Open window immediately to avoid popup blocker
  const printWin = window.open('', '_blank', 'width=400,height=600');
  if (!printWin) {
    alert("Please allow pop-ups to print the summary!");
    return;
  }
  printWin.document.open();
  printWin.document.write('<div style="font-family:sans-serif;text-align:center;margin-top:50px;">Generating summary, please wait...</div>');

  // Fetch and filter Expenses
  let totalExpense = 0;
  try {
    const res = await fetch('/api/expenses');
    if (res.ok) {
      const expenses = await res.json();
      expenses.forEach(exp => {
        const expDate = new Date(exp.paid_at || exp.created_at);
        let matchDate = true;
        if (startD && expDate < startD) matchDate = false;
        if (endD && expDate > endD) matchDate = false;
        if (exp.status === 'paid' && matchDate) {
          totalExpense += Number(exp.amount || 0);
        }
      });
    }
  } catch (err) {
    console.error("Error fetching expenses", err);
  }

  const grossProfit = totalSale - totalCostOfGoods;
  const netProfit = grossProfit - totalExpense;

  let medsHTML = '';
  // Sort medicines by count descending
  const sortedMeds = Object.entries(medsSold).sort((a, b) => b[1] - a[1]);
  
  for (const [name, qty] of sortedMeds) {
    medsHTML += `
      <div style="display:flex; justify-content:space-between; margin-bottom: 4px;">
        <span style="font-size: 13px;">${name}</span>
        <span style="font-size: 13px; font-weight: bold;">${qty}</span>
      </div>
    `;
  }

  if (!medsHTML) medsHTML = '<div style="font-size:12px; color:#666;">No medicines sold in this period.</div>';

  const dateRangeStr = (startStr || endStr) 
    ? `${startStr ? startStr : 'Beginning'} to ${endStr ? endStr : 'Today'}`
    : 'All Time';

  const html = `
    <!DOCTYPE html>
    <html>
    <head>
      <title>Sales Summary</title>
      <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
        @page { size: 80mm auto; margin: 4mm 3mm; }
        body { background: #fff; width: 76mm; padding: 0; color: #000; font-size: 13px; }
        .center { text-align: center; }
        h2 { font-size: 20px; font-weight: normal; margin-bottom: 5px; }
        .date { font-size: 11px; color: #444; margin-bottom: 15px; border-bottom: 1px dashed #000; padding-bottom: 5px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 6px; }
        .total-row { display: flex; justify-content: space-between; margin-top: 10px; padding-top: 10px; border-top: 2px dashed #000; font-size: 16px; font-weight: bold; }
        .profit-row { display: flex; justify-content: space-between; margin-top: 5px; padding: 10px 0; border-top: 1px dashed #000; border-bottom: 1px dashed #000; font-size: 18px; font-weight: bold; }
        .meds-header { font-weight: bold; font-size: 14px; margin-top: 15px; margin-bottom: 8px; text-decoration: underline; }
      </style>
    </head>
    <body onload="setTimeout(function(){ window.print(); window.close(); }, 500);">
      <div class="center">
        <h2>Sales Summary</h2>
        <div class="date">${dateRangeStr}</div>
      </div>
      
      <div class="row">
        <span>Total Sales (Revenue)</span>
        <span>PKR ${totalSale.toFixed(2)}</span>
      </div>
      <div class="row">
        <span>Total Purchase Cost</span>
        <span>PKR ${totalCostOfGoods.toFixed(2)}</span>
      </div>
      <div class="row" style="font-weight:bold; margin-top:5px; margin-bottom:10px;">
        <span>Gross Profit</span>
        <span>PKR ${grossProfit.toFixed(2)}</span>
      </div>
      <div class="row">
        <span>Total Expenses</span>
        <span>PKR ${totalExpense.toFixed(2)}</span>
      </div>
      
      <div class="profit-row">
        <span>Net Profit</span>
        <span>PKR ${netProfit.toFixed(2)}</span>
      </div>

      <div class="meds-header">Medicines Sold (By Count)</div>
      ${medsHTML}
      
      <div class="center" style="margin-top: 20px; font-size: 11px; color: #555;">
        Printed on: ${new Date().toLocaleString()}
      </div>
    </body>
    </html>
  `;

  printWin.document.open();
  printWin.document.write(html);
  printWin.document.close();
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

async function saveMedicine() {
  const name = document.getElementById('medName').value.trim();
  const catId = document.getElementById('medCat').value;
  const sale = document.getElementById('medSale').value;
  
  if (!name || !catId || !sale) { toast('Name, Category, and Sale Price required!', 'warning'); return; }
  
  const editId = document.getElementById('medId').value;
  const data = {
    name,
    category_id: catId,
    supplier_id: document.getElementById('medSupplier').value || null,
    generic_name: document.getElementById('medGeneric').value.trim(),
    company: document.getElementById('medCompany').value.trim(),
    batch_number: document.getElementById('medBatch').value.trim(),
    barcode: document.getElementById('medBarcode').value.trim(),
    purchase_price: document.getElementById('medPurchase').value || 0,
    sale_price: sale,
    stock_quantity: document.getElementById('medStock').value || 0,
    low_stock_level: document.getElementById('medLowStock').value || 10,
    expiry_date: document.getElementById('medExpiry').value || null,
    mfg_date: document.getElementById('medMfg').value || null,
    rack: document.getElementById('medRack').value.trim(),
    requires_prescription: document.getElementById('medRx').value === 'yes' ? 1 : 0,
    description: document.getElementById('medDesc').value.trim()
  };
  
  try {
      if (editId) {
          await api('/medicines/' + editId, 'PUT', data);
          toast('Medicine updated!', 'success');
      } else {
          await api('/medicines', 'POST', data);
          toast('Medicine added!', 'success');
      }
      closeMedModal();
      await syncData();
  } catch(e) { toast('Error saving medicine', 'danger'); }
}

function deleteMedicine(id) {
  confirmDelete('Delete this medicine?', async () => {
    try {
        await api('/medicines/' + id, 'DELETE');
        toast('Medicine deleted', 'danger');
        await syncData();
    } catch(e) { toast('Error deleting', 'danger'); }
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

async function saveCategory() {
  const name = document.getElementById('catName').value.trim();
  if (!name) { toast('Category name is required!', 'warning'); return; }
  
  const editId = document.getElementById('catEditId').value;
  const data = {
    name,
    description: document.getElementById('catDesc').value.trim(),
    color_tag: document.getElementById('catColor').value
  };
  
  try {
      if (editId) {
          await api('/categories/' + editId, 'PUT', data);
          toast('Category updated!', 'success');
      } else {
          await api('/categories', 'POST', data);
          toast('Category added!', 'success');
      }
      resetCatForm();
      await syncData();
  } catch(e) { toast('Error saving category', 'danger'); }
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
  confirmDelete('Delete this category?', async () => {
    try {
        await api('/categories/' + id, 'DELETE');
        toast('Category deleted', 'danger');
        await syncData();
    } catch(e) { toast('Error deleting category', 'danger'); }
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

async function saveSupplier() {
  const name = document.getElementById('suppName').value.trim();
  const phone = document.getElementById('suppPhone').value.trim();
  if (!name || !phone) { toast('Name and phone required!', 'warning'); return; }
  
  const editId = document.getElementById('suppId').value;
  const data = {
    name, phone,
    company_name: document.getElementById('suppCompany').value.trim(),
    email: document.getElementById('suppEmail').value.trim(),
    address: document.getElementById('suppAddress').value.trim(),
    notes: document.getElementById('suppNotes').value.trim(),
  };
  
  try {
      if (editId) {
          await api('/suppliers/' + editId, 'PUT', data);
          toast('Supplier updated!', 'success');
      } else {
          await api('/suppliers', 'POST', data);
          toast('Supplier added!', 'success');
      }
      closeSuppModal();
      await syncData();
  } catch(e) { toast('Error saving supplier', 'danger'); }
}

function deleteSupplier(id) {
  confirmDelete('Delete this supplier?', async () => {
    try {
        await api('/suppliers/' + id, 'DELETE');
        toast('Supplier deleted', 'danger');
        await syncData();
    } catch(e) { toast('Error deleting', 'danger'); }
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

async function saveCustomer() {
  const name = document.getElementById('custName').value.trim();
  const phone = document.getElementById('custPhone').value.trim();
  if (!name || !phone) { toast('Name and phone required!', 'warning'); return; }
  
  const editId = document.getElementById('custId').value;
  const data = {
    name, phone,
    email: document.getElementById('custEmail').value.trim(),
    age: parseInt(document.getElementById('custAge').value) || null,
    gender: document.getElementById('custGender').value,
    address: document.getElementById('custAddress').value.trim(),
  };
  
  try {
      if (editId) {
          await api('/customers/' + editId, 'PUT', data);
          toast('Customer updated!', 'success');
      } else {
          await api('/customers', 'POST', data);
          toast('Customer added!', 'success');
      }
      closeCustModal();
      await syncData();
  } catch(e) { toast('Error saving customer', 'danger'); }
}

function deleteCustomer(id) {
  confirmDelete('Delete this customer?', async () => {
    try {
        await api('/customers/' + id, 'DELETE');
        toast('Customer deleted', 'danger');
        await syncData();
    } catch(e) { toast('Error deleting', 'danger'); }
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

function printAlerts() {
  const meds = store.get('medicines');
  const cats = store.get('categories');
  const catName = id => (cats.find(c => c.id == id) || {}).name || '-';

  const expired = meds.filter(m => isExpired(m.expiry));
  const expiringSoon = meds.filter(m => { const d = daysDiff(m.expiry); return d >= 0 && d <= 30; });
  const lowStock = meds.filter(m => isLowStock(m));

  let html = `
    <!DOCTYPE html>
    <html>
    <head>
      <title>Alerts Summary Report</title>
      <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
        @page { size: auto; margin: 10mm; }
        body { background: #fff; padding: 20px; color: #000; font-size: 13px; }
        .center { text-align: center; }
        h2 { font-size: 20px; font-weight: bold; margin-bottom: 5px; }
        h3 { font-size: 16px; margin-top: 20px; margin-bottom: 10px; border-bottom: 1px solid #000; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #eee; font-weight: bold; }
      </style>
    </head>
    <body onload="setTimeout(function(){ window.print(); window.close(); }, 500);">
      <div class="center">
        <h2>Alerts Summary Report</h2>
        <div style="font-size:11px; color:#444;">Printed on: ${new Date().toLocaleString()}</div>
      </div>
  `;

  if (expired.length) {
    html += '<h3>Expired Medicines</h3><table><tr><th>Medicine</th><th>Category</th><th>Stock</th><th>Expiry</th><th>Days Ago</th></tr>';
    expired.forEach(m => {
      html += '<tr><td>' + m.name + '</td><td>' + catName(m.catId) + '</td><td>' + m.stock + '</td><td>' + fmtDate(m.expiry) + '</td><td>' + Math.abs(daysDiff(m.expiry)) + '</td></tr>';
    });
    html += '</table>';
  }

  if (expiringSoon.length) {
    html += '<h3>Expiring Soon (30 days)</h3><table><tr><th>Medicine</th><th>Category</th><th>Stock</th><th>Expiry</th><th>Days Left</th></tr>';
    expiringSoon.forEach(m => {
      html += '<tr><td>' + m.name + '</td><td>' + catName(m.catId) + '</td><td>' + m.stock + '</td><td>' + fmtDate(m.expiry) + '</td><td>' + daysDiff(m.expiry) + '</td></tr>';
    });
    html += '</table>';
  }

  if (lowStock.length) {
    html += '<h3>Low Stock Medicines</h3><table><tr><th>Medicine</th><th>Category</th><th>Stock</th><th>Low Stock Level</th><th>Rack</th></tr>';
    lowStock.forEach(m => {
      html += '<tr><td>' + m.name + '</td><td>' + catName(m.catId) + '</td><td>' + m.stock + '</td><td>' + m.lowStock + '</td><td>' + (m.rack || '-') + '</td></tr>';
    });
    html += '</table>';
  }

  if (!expired.length && !expiringSoon.length && !lowStock.length) {
    html += '<div style="margin-top:20px;text-align:center;">No alerts at this time.</div>';
  }

  html += '</body></html>';

  const printWin = window.open('', '_blank', 'width=800,height=600');
  if (!printWin) {
    alert("Please allow pop-ups to print the summary!");
    return;
  }
  printWin.document.open();
  printWin.document.write(html);
  printWin.document.close();
}

// ============================================================
// INIT
// ============================================================
document.addEventListener('DOMContentLoaded', () => {
  // seedDemoData();
  syncData();
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
  // navigate('dashboard'); // Removed to prevent infinite reload loop in MPA mode
});

function toggleFullscreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().catch(err => {
      console.log(`Error attempting to enable fullscreen: ${err.message} (${err.name})`);
    });
  } else {
    document.exitFullscreen();
  }
}