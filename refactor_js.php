<?php

$jsPath = 'public/assets/js/script.js';
$js = file_get_contents($jsPath);

// 1. Inject API helper and sync function
$apiSync = "
async function api(url, method = 'GET', body = null) {
    const opts = {
        method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    };
    if (body) opts.body = JSON.stringify(body);
    const res = await fetch(url, opts);
    if (!res.ok) throw new Error('API Error');
    if (method !== 'DELETE') return await res.json();
    return true;
}

async function syncData() {
    try {
        const [cats, meds, supps, custs] = await Promise.all([
            api('/categories'),
            api('/medicines'),
            api('/suppliers'),
            api('/customers')
        ]);
        
        // Map DB columns to frontend expected fields if necessary
        // The frontend expects: catId instead of category_id, supplierId instead of supplier_id
        const mappedMeds = meds.map(m => ({...m, catId: m.category_id, supplierId: m.supplier_id, stock: m.stock_quantity, lowStock: m.low_stock_level, sale: m.sale_price, purchase: m.purchase_price, expiry: m.expiry_date, mfg: m.mfg_date, generic: m.generic_name }));
        
        store.set('categories', cats);
        store.set('medicines', mappedMeds);
        store.set('suppliers', supps);
        store.set('customers', custs);
        
        // Re-render current page
        renderPage(currentPage);
    } catch(e) {
        console.error('Failed to sync data', e);
        toast('Database connection error', 'danger');
    }
}
";

$js = str_replace("// ============================================================\n// STATE", $apiSync . "\n// ============================================================\n// STATE", $js);

// 2. Disable seedDemoData and call syncData on load
$js = str_replace("seedDemoData();", "// seedDemoData();\n  syncData();", $js);

// 3. Rewrite saveCategory
$newSaveCategory = "async function saveCategory() {
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
}";
// Replace the old saveCategory
$js = preg_replace('/function saveCategory\(\) \{[\s\S]*?renderCategories\(\);\n\}/', $newSaveCategory, $js);

// 4. Rewrite deleteCategory
$newDeleteCategory = "function deleteCategory(id) {
  confirmDelete('Delete this category?', async () => {
    try {
        await api('/categories/' + id, 'DELETE');
        toast('Category deleted', 'danger');
        await syncData();
    } catch(e) { toast('Error deleting category', 'danger'); }
  });
}";
$js = preg_replace('/function deleteCategory\(id\) \{[\s\S]*?renderCategories\(\);\n  \}\);\n\}/', $newDeleteCategory, $js);

// 5. Rewrite saveSupplier
$newSaveSupplier = "async function saveSupplier() {
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
}";
$js = preg_replace('/function saveSupplier\(\) \{[\s\S]*?renderSuppliers\(\);\n\}/', $newSaveSupplier, $js);

// 6. Rewrite deleteSupplier
$newDeleteSupplier = "function deleteSupplier(id) {
  confirmDelete('Delete this supplier?', async () => {
    try {
        await api('/suppliers/' + id, 'DELETE');
        toast('Supplier deleted', 'danger');
        await syncData();
    } catch(e) { toast('Error deleting', 'danger'); }
  });
}";
$js = preg_replace('/function deleteSupplier\(id\) \{[\s\S]*?renderSuppliers\(\);\n  \}\);\n\}/', $newDeleteSupplier, $js);

// 7. Rewrite saveCustomer
$newSaveCustomer = "async function saveCustomer() {
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
}";
$js = preg_replace('/function saveCustomer\(\) \{[\s\S]*?renderCustomers\(\);\n\}/', $newSaveCustomer, $js);

// 8. Rewrite deleteCustomer
$newDeleteCustomer = "function deleteCustomer(id) {
  confirmDelete('Delete this customer?', async () => {
    try {
        await api('/customers/' + id, 'DELETE');
        toast('Customer deleted', 'danger');
        await syncData();
    } catch(e) { toast('Error deleting', 'danger'); }
  });
}";
$js = preg_replace('/function deleteCustomer\(id\) \{[\s\S]*?renderCustomers\(\);\n  \}\);\n\}/', $newDeleteCustomer, $js);

// 9. Rewrite saveMedicine
$newSaveMedicine = "async function saveMedicine() {
  const name = document.getElementById('medName').value.trim();
  const catId = document.getElementById('medCategory').value;
  const sale = document.getElementById('medSalePrice').value;
  
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
    purchase_price: document.getElementById('medPurchasePrice').value || 0,
    sale_price: sale,
    stock_quantity: document.getElementById('medStock').value || 0,
    low_stock_level: document.getElementById('medLowStock').value || 10,
    expiry_date: document.getElementById('medExpiry').value || null,
    mfg_date: document.getElementById('medMfg').value || null,
    rack: document.getElementById('medRack').value.trim(),
    requires_prescription: document.getElementById('medRx').checked ? 1 : 0,
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
}";
$js = preg_replace('/function saveMedicine\(\) \{[\s\S]*?renderMedicines\(\);\n\}/', $newSaveMedicine, $js);

// 10. Rewrite deleteMedicine
$newDeleteMedicine = "function deleteMedicine(id) {
  confirmDelete('Delete this medicine?', async () => {
    try {
        await api('/medicines/' + id, 'DELETE');
        toast('Medicine deleted', 'danger');
        await syncData();
    } catch(e) { toast('Error deleting', 'danger'); }
  });
}";
$js = preg_replace('/function deleteMedicine\(id\) \{[\s\S]*?renderMedicines\(\);\n  \}\);\n\}/', $newDeleteMedicine, $js);

// 11. Fix map fields for editing
// Since we mapped DB names (like generic_name to generic) when reading, we just need to make sure the openModal functions use the right properties if they changed. I already mapped them in syncData! So openMedModal, openCatModal etc. will still work without changes!

file_put_contents($jsPath, $js);
echo "JavaScript CRUD updated for AJAX.\n";
