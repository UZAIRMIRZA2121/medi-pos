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
        <div class="form-group"><label>Purchase Price (Rs.)</label><input type="number" id="medPurchase" class="input" min="0" step="0.01"/></div>
        <div class="form-group"><label>Sale Price (Rs.) *</label><input type="number" id="medSale" class="input" min="0" step="0.01"/></div>
        <div class="form-group"><label>Stock Quantity *</label><input type="number" id="medStock" class="input" min="0"/></div>
        <div class="form-group"><label>Low Stock Level</label><input type="number" id="medLowStock" class="input" min="0" value="10"/></div>
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