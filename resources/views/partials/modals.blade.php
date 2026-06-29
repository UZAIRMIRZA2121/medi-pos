<!-- Medicine Modal -->
<div class="modal-overlay hidden" id="medModal">
  <div class="modal modal-lg">
    <div class="modal-header">
      <h3 id="medModalTitle">Add Medicine</h3>
      <button class="modal-close" onclick="closeMedModal()">×</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="medId"/>
      <div class="form-grid">
        <div class="form-group"><label>Medicine Name *</label><input type="text" id="medName" class="input" placeholder="Brand name"/></div>
        <div class="form-group"><label>Generic Name</label><input type="text" id="medGeneric" class="input" placeholder="Generic/Chemical name"/></div>
        <div class="form-group"><label>Category *</label><select id="medCat" class="input"><option value="">Select category</option></select></div>
        <div class="form-group"><label>Company / Brand</label><input type="text" id="medCompany" class="input" placeholder="Manufacturer"/></div>
        <div class="form-group"><label>Batch Number</label><input type="text" id="medBatch" class="input"/></div>
        <div class="form-group"><label>Barcode</label><input type="text" id="medBarcode" class="input"/></div>
        <div class="form-group" style="display: none;"><label>Purchase Price (PKR)</label><input type="number" id="medPurchase" class="input" min="0" step="0.01"/></div>
        <div class="form-group" style="display: none;"><label>Sale Price (PKR) *</label><input type="number" id="medSale" class="input" min="0" step="0.01"/></div>
        <div class="form-group" style="display: none;"><label>Stock Quantity *</label><input type="number" id="medStock" class="input" min="0"/></div>
        <div class="form-group"><label>Low Stock Level (Packs)</label><input type="number" id="medLowStock" class="input" min="0" value="10"/></div>
        <div class="form-group"><label>Purchase Price Per Pack</label><input type="number" id="medPackPurchase" class="input" min="0" step="0.01"/></div>
        <div class="form-group"><label>Sale Price Per Pack</label><input type="number" id="medPackSale" class="input" min="0" step="0.01"/></div>
        <div class="form-group"><label>Pack Stock Qty</label><input type="number" id="medPackStock" class="input" min="0"/></div>
        <div class="form-group"><label>Items Per Pack</label><input type="number" id="medItemsPerPack" class="input" min="1" value="1"/></div>
        <div class="form-group"><label>Expiry Date *</label><input type="date" id="medExpiry" class="input"/></div>
        <div class="form-group"><label>Manufacturing Date</label><input type="date" id="medMfg" class="input"/></div>
        <div class="form-group"><label>Supplier</label><select id="medSupplier" class="input"><option value="">Select supplier</option></select></div>
        <div class="form-group"><label>Rack / Shelf</label><input type="text" id="medRack" class="input" placeholder="e.g. A-1"/></div>
        <div class="form-group"><label>Prescription Required</label><select id="medRx" class="input"><option value="no">No</option><option value="yes">Yes</option></select></div>
        <div class="form-group form-full"><label>Description</label><textarea id="medDesc" class="input" rows="2" placeholder="Optional..."></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeMedModal()">Cancel</button>
      <button class="btn btn-primary" onclick="saveMedicine()">Save Medicine</button>
    </div>
  </div>
</div>

<!-- Supplier Modal -->
<div class="modal-overlay hidden" id="suppModal">
  <div class="modal">
    <div class="modal-header">
      <h3 id="suppModalTitle">Add Supplier</h3>
      <button class="modal-close" onclick="closeSuppModal()">×</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="suppId"/>
      <div class="form-grid">
        <div class="form-group"><label>Supplier Name *</label><input type="text" id="suppName" class="input"/></div>
        <div class="form-group"><label>Company Name</label><input type="text" id="suppCompany" class="input"/></div>
        <div class="form-group"><label>Phone *</label><input type="text" id="suppPhone" class="input"/></div>
        <div class="form-group"><label>Email</label><input type="email" id="suppEmail" class="input"/></div>
        <div class="form-group form-full"><label>Address</label><textarea id="suppAddress" class="input" rows="2"></textarea></div>
        <div class="form-group form-full"><label>Notes</label><textarea id="suppNotes" class="input" rows="2"></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeSuppModal()">Cancel</button>
      <button class="btn btn-primary" onclick="saveSupplier()">Save Supplier</button>
    </div>
  </div>
</div>

<!-- Customer Modal -->
<div class="modal-overlay hidden" id="custModal">
  <div class="modal">
    <div class="modal-header">
      <h3 id="custModalTitle">Add Customer</h3>
      <button class="modal-close" onclick="closeCustModal()">×</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="custId"/>
      <div class="form-grid">
        <div class="form-group"><label>Customer Name *</label><input type="text" id="custName" class="input"/></div>
        <div class="form-group"><label>Phone *</label><input type="text" id="custPhone" class="input"/></div>
        <div class="form-group"><label>Email</label><input type="email" id="custEmail" class="input"/></div>
        <div class="form-group"><label>Age</label><input type="number" id="custAge" class="input" min="0"/></div>
        <div class="form-group"><label>Gender</label><select id="custGender" class="input"><option value="male">Male</option><option value="female">Female</option><option value="other">Other</option></select></div>
        <div class="form-group form-full"><label>Address</label><textarea id="custAddress" class="input" rows="2"></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeCustModal()">Cancel</button>
      <button class="btn btn-primary" onclick="saveCustomer()">Save Customer</button>
    </div>
  </div>
</div>

<!-- Invoice Preview Modal -->
<div class="modal-overlay hidden" id="invoiceModal">
  <div class="modal modal-lg">
    <div class="modal-header">
      <h3>Invoice Preview</h3>
      <button class="modal-close" onclick="closeInvoiceModal()">×</button>
    </div>
    <div class="modal-body" id="invoicePreview" style="background:#f0f0f0;padding:24px"></div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeInvoiceModal()">Close</button>
      <button class="btn btn-primary" onclick="printInvoice()">Print Invoice</button>
    </div>
  </div>
</div>

<!-- Confirm Modal -->
<div class="modal-overlay hidden" id="confirmModal">
  <div class="modal modal-sm">
    <div class="modal-header">
      <h3>Confirm Delete</h3>
      <button class="modal-close" onclick="closeConfirmModal()">×</button>
    </div>
    <div class="modal-body">
      <p id="confirmMsg">Are you sure you want to delete this item? This action cannot be undone.</p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeConfirmModal()">Cancel</button>
      <button class="btn btn-danger" id="confirmOkBtn">Delete</button>
    </div>
  </div>
</div>

<!-- Supplier Order Modal -->
<div class="modal-overlay hidden" id="supplierOrderModal">
  <div class="modal modal-lg">
    <div class="modal-header">
      <h3>Purchase Order: <span id="orderSupplierName"></span></h3>
      <button class="modal-close" onclick="document.getElementById('supplierOrderModal').classList.add('hidden');">×</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="orderSupplierId"/>
      <div class="table-wrap">
        <table class="table">
          <thead>
            <tr>
              <th>Medicine</th>
              <th>Order Qty (Packs)</th>
              <th width="50"></th>
            </tr>
          </thead>
          <tbody id="supplierOrderTbody">
            <!-- Populated via JS -->
          </tbody>
        </table>
      </div>
      <div class="mt-4">
        <label class="label">Order Notes</label>
        <textarea id="orderNotes" class="input w-full" rows="2" placeholder="Optional notes for this purchase order..."></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="document.getElementById('supplierOrderModal').classList.add('hidden');">Cancel</button>
      <button class="btn btn-primary" onclick="printSupplierOrder()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2" style="margin-right:8px;vertical-align:text-bottom;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
        Print Invoice
      </button>
    </div>
  </div>
</div>

<!-- Purchase Order Details Modal -->
<div id="purchaseOrderDetailsModal" class="modal-overlay hidden">
  <div class="modal" style="max-width: 600px;">
    <div class="modal-header">
      <h3 class="modal-title">Purchase Order Details</h3>
      <button class="close-btn" onclick="document.getElementById('purchaseOrderDetailsModal').classList.add('hidden');">&times;</button>
    </div>
    <div class="modal-body">
      <div class="table-responsive">
        <table class="table w-full">
          <thead>
            <tr>
              <th>Medicine</th>
              <th>Quantity (Packs)</th>
            </tr>
          </thead>
          <tbody id="detailOrderItemsTbody">
            <!-- Items populated dynamically -->
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="document.getElementById('purchaseOrderDetailsModal').classList.add('hidden');">Close</button>
    </div>
  </div>
</div>

<!-- Edit Purchase Order Modal -->
<div id="editPurchaseOrderModal" class="modal-overlay hidden">
  <div class="modal" style="max-width: 600px;">
    <div class="modal-header">
      <h3 class="modal-title">Edit Purchase Order</h3>
      <button class="close-btn" onclick="document.getElementById('editPurchaseOrderModal').classList.add('hidden');">&times;</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="editOrderId" value="">
      <div class="table-responsive">
        <table class="table w-full">
          <thead>
            <tr>
              <th>Medicine</th>
              <th>Quantity (Packs)</th>
            </tr>
          </thead>
          <tbody id="editOrderItemsTbody">
            <!-- Items populated dynamically -->
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="document.getElementById('editPurchaseOrderModal').classList.add('hidden');">Cancel</button>
      <button class="btn btn-primary" onclick="savePurchaseOrderEdit()">Save Changes</button>
    </div>
  </div>
</div>