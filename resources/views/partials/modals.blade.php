<!-- Medicine Modal -->
<div class="modal-overlay hidden" id="medModal">
  <div class="modal modal-lg">
    <div class="modal-header">
      <h3 id="medModalTitle">Add Medicine</h3>
      <button class="modal-close" onclick="closeMedModal()">Ã—</button>
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
        <div class="form-group"><label>Purchase Price Per Pack</label><input type="number" id="medPackPurchase" class="input" min="0" step="0.01"/></div>
        <div class="form-group"><label>Sale Price Per Pack</label><input type="number" id="medPackSale" class="input" min="0" step="0.01"/></div>
        <div class="form-group"><label>Pack Stock Qty</label><input type="number" id="medPackStock" class="input" min="0"/></div>
        <div class="form-group"><label>Low Stock Level (Packs)</label><input type="number" id="medLowStock" class="input" min="0" value="10"/></div>
        <div class="form-group"><label>Items(Tabs,Caps,ml,...) Per Pack</label><input type="number" id="medItemsPerPack" class="input" min="1" value="1"/></div>
        <div class="form-group"><label>Supplier</label><select id="medSupplier" class="input"><option value="">Select supplier</option></select></div>
        <div class="form-group"><label>Manufacturing Date</label><input type="date" id="medMfg" class="input"/></div>
        <div class="form-group"><label>Expiry Date *</label><input type="date" id="medExpiry" class="input"/></div>
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
      <button class="modal-close" onclick="closeSuppModal()">Ã—</button>
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
      <button class="modal-close" onclick="closeCustModal()">Ã—</button>
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
      <button class="modal-close" onclick="closeInvoiceModal()">Ã—</button>
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
      <button class="modal-close" onclick="closeConfirmModal()">Ã—</button>
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
      <button class="modal-close" onclick="document.getElementById('supplierOrderModal').classList.add('hidden');">Ã—</button>
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
      <button class="btn btn-primary" onclick="saveSupplierOrder()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2" style="margin-right:8px;vertical-align:text-bottom;"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
        Place Order
      </button>
    </div>
  </div>
</div>

<!-- Purchase Order Details Modal -->
<div id="purchaseOrderDetailsModal" class="modal-overlay hidden">
  <div class="modal" style="max-width: 600px;">
    <div class="modal-header">
      <h3 class="modal-title">Purchase Order Details</h3>
      <button class="btn btn-danger btn-sm" style="padding: 2px 8px; font-weight: bold;" onclick="document.getElementById('purchaseOrderDetailsModal').classList.add('hidden');">&times;</button>
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

<!-- Refund Modal -->
<div class="modal-overlay hidden" id="refundModal">
  <div class="modal modal-lg" style="max-width: 800px;">
    <div class="modal-header">
      <h3 class="modal-title">Refund Invoice: <span id="refundInvoiceNumber"></span></h3>
      <button class="btn btn-danger btn-sm" style="padding: 2px 8px; font-weight: bold;" onclick="document.getElementById('refundModal').classList.add('hidden');">&times;</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="refundInvoiceId" value="">
      <div class="table-responsive">
        <table class="table w-full">
          <thead>
            <tr>
              <th>Medicine</th>
              <th>Price</th>
              <th>Qty Sold</th>
              <th>Refund Qty</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="refundItemsTbody">
            <!-- Items populated dynamically -->
          </tbody>
        </table>
      </div>
      <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: flex-start;">
        <div id="refundAmounts" style="font-weight: 500; font-size: 14px; display: flex; flex-direction: column; gap: 8px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <label style="margin: 0; min-width: 100px;">Paid Amount:</label>
            <input type="number" id="refInputPaidAmt" class="input input-sm" style="width: 120px;" min="0" step="0.01" oninput="calculateRefundTotal()">
          </div>
          <div style="display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--text-muted);">
            <label style="margin: 0; min-width: 100px;">Already Returned:</label>
            <span id="refAlreadyReturned">PKR 0.00</span>
          </div>
          <div style="display: flex; align-items: center; gap: 10px;">
            <label style="margin: 0; min-width: 100px; color: var(--info);">Refund Amt (Now):</label>
            <span id="refChangeAmt" style="color:var(--info); font-weight: bold; font-size: 16px;">0.00</span>
          </div>
          <div style="margin-top: 5px; color: var(--danger); font-weight: bold; font-size: 15px;">
            Invoice New Total: <span id="refTotalAmountToReturn">PKR 0.00</span>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-danger" style="margin-right: auto;" onclick="completeFullRefund()">Complete Invoice Refund</button>
      <button class="btn btn-ghost" onclick="document.getElementById('refundModal').classList.add('hidden');">Cancel</button>
      <button class="btn btn-primary" onclick="saveRefundChanges()">Save Changes</button>
    </div>
  </div>
</div>

<!-- Edit Invoice Modal -->
<div class="modal-overlay hidden" id="editInvoiceModal">
  <div class="modal" style="max-width: 500px;">
    <div class="modal-header">
      <h3 class="modal-title">Edit Invoice: <span id="editInvoiceNumber"></span></h3>
      <button class="btn btn-danger btn-sm" style="padding: 2px 8px; font-weight: bold;" onclick="document.getElementById('editInvoiceModal').classList.add('hidden');">&times;</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="editInvoiceId" value="">
      <div class="form-grid">
        <div class="form-group">
          <label>Subtotal (PKR)</label>
          <input type="number" id="editInvSubtotal" class="input" style="background:#f0f0f0;" readonly>
        </div>
        <div class="form-group">
          <label>Discount (%)</label>
          <input type="number" id="editInvDiscount" class="input" min="0" max="100" step="0.01" oninput="calculateEditInvoiceTotal()">
        </div>
        <div class="form-group">
          <label>Tax (%)</label>
          <input type="number" id="editInvTax" class="input" min="0" max="100" step="0.01" oninput="calculateEditInvoiceTotal()">
        </div>
        <div class="form-group">
          <label>Grand Total (PKR)</label>
          <input type="number" id="editInvGrandTotal" class="input" style="background:#f0f0f0;" readonly>
        </div>
        <div class="form-group">
          <label>Paid Amount (PKR)</label>
          <input type="number" id="editInvPaidAmt" class="input" min="0" step="0.01" oninput="calculateEditInvoiceTotal()">
        </div>
      </div>
      <div style="margin-top: 15px; font-weight: 500; font-size: 14px; display: flex; flex-direction: column; gap: 8px;">
        <div style="display: flex; justify-content: space-between;">
          <span>Due Amount:</span>
          <span id="editInvDueAmt" style="color:var(--danger); font-weight: bold;">0.00</span>
        </div>
        <div style="display: flex; justify-content: space-between;">
          <span>Return Amount:</span>
          <span id="editInvReturnAmt" style="color:var(--info); font-weight: bold;">0.00</span>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="document.getElementById('editInvoiceModal').classList.add('hidden');">Cancel</button>
      <button class="btn btn-primary" onclick="saveEditInvoiceChanges()">Save Changes</button>
    </div>
  </div>
</div>

<!-- Staff Modal -->
<div class="modal-overlay hidden" id="staffModal">
  <div class="modal" style="max-width: 500px;">
    <div class="modal-header">
      <h3 class="modal-title" id="staffModalTitle">Add Staff</h3>
      <button class="btn btn-danger btn-sm" style="padding: 2px 8px; font-weight: bold;" onclick="closeStaffModal()">&times;</button>
    </div>
    <div class="modal-body">
      <form id="staffForm">
        <input type="hidden" id="staffId">
        <div class="form-group">
          <label>Name</label>
          <input type="text" id="staffName" class="input w-full" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" id="staffEmail" class="input w-full" required>
        </div>
        <div class="form-group">
          <label>Role</label>
          <select id="staffRole" class="input w-full" required>
            <option value="cashier">Cashier</option>
            <option value="manager">Manager</option>
          </select>
        </div>
        <div class="form-group">
          <label>Privileges</label>
          @php
              $privilegesGroups = \App\Models\Privilege::all()->groupBy('group');
          @endphp
          <div id="staffPrivilegesList" style="max-height: 200px; overflow-y: auto; border: 1px solid var(--border); padding: 10px; border-radius: 4px;">
              @foreach($privilegesGroups as $group => $privs)
                  <div style="margin-bottom: 10px;">
                      <strong style="display: block; font-size: 12px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 5px;">{{ $group }}</strong>
                      <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                      @foreach($privs as $priv)
                          <label style="display: flex; align-items: center; gap: 5px; font-size: 13px;">
                              <input type="checkbox" class="staff-privilege-cb" value="{{ $priv->slug }}">
                              {{ $priv->name }}
                          </label>
                      @endforeach
                      </div>
                  </div>
              @endforeach
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeStaffModal()">Cancel</button>
      <button class="btn btn-primary" onclick="saveStaff()">Save Staff</button>
    </div>
  </div>
</div>

<!-- Shortcuts Modal -->
<div class="modal-overlay hidden" id="shortcutsModal">
  <div class="modal modal-lg" style="max-width: 800px;">
    <div class="modal-header">
      <h3 class="modal-title">Keyboard Shortcuts</h3>
      <button class="btn btn-danger btn-sm" style="padding: 2px 8px; font-weight: bold;" onclick="document.getElementById('shortcutsModal').classList.add('hidden');">&times;</button>
    </div>
    <div class="modal-body" style="padding: 20px;">
      <p style="margin-bottom: 20px; color: var(--muted);">Use these keyboard shortcuts to navigate the POS screen efficiently without using your mouse.</p>
      <div class="table-responsive">
        <table class="table w-full" style="text-align: left;">
          <thead>
            <tr style="border-bottom: 1px solid var(--border);">
              <th style="padding: 12px 10px; width: 250px;">Shortcut Key</th>
              <th style="padding: 12px 10px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Any Letter / Number</strong></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Automatically focus the Medicine Search Bar and start typing.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Arrow Keys</strong></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Navigate up, down, left, and right through the Medicine grid.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Enter</strong> <small>(on Medicine)</small></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Add the currently highlighted medicine to the cart. Press multiple times to increase quantity.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Backspace</strong> <small>(on Medicine)</small></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Decrease the cart quantity of the highlighted medicine by 1.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Delete</strong> <small>(on Medicine)</small></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Instantly remove the highlighted medicine from the cart completely.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Esc</strong></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Clear the search bar and reset the medicine grid.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Ctrl</strong></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Cycle focus through Discount, Tax, and Paid Amount fields in the Bill Summary.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Shift</strong></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Instantly jump focus back to the Medicine Search Bar.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Enter</strong> <small>(in Bill Summary)</small></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Generate Invoice (trigger checkout) when focused on Discount, Tax, or Paid Amount.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>F8</strong></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Generate Invoice from anywhere on the POS page.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Shift + Delete</strong> / <strong>F9</strong></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Clear the entire cart instantly.</td>
            </tr>
            <tr style="border-bottom: 1px solid var(--border);">
              <td style="padding: 12px 10px;"><strong>Enter</strong> <small>(in Invoice Preview)</small></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Print Invoice when the Invoice Preview modal is open.</td>
            </tr>
            <tr>
              <td style="padding: 12px 10px;"><strong>Esc</strong> <small>(in Invoice Preview)</small></td>
              <td style="padding: 12px 10px; color: var(--text-muted);">Close the Invoice Preview modal.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="document.getElementById('shortcutsModal').classList.add('hidden');">Close</button>
    </div>
  </div>
</div>
