@extends('layouts.app')

@section('content')
<main class="page-content">
    <div class="page" id="page-expenses">
      <div class="card">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
          <h3>Expenses</h3>
          <button class="btn btn-primary btn-sm" onclick="document.getElementById('addExpenseModal').style.display='flex'">+ Add Expense</button>
        </div>
        
        @if(session('success'))
            <div style="padding: 10px; background-color: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 15px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="table-wrap">
          <table class="table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Paid At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                <tr>
                    <td>
                        @if($expense->img)
                            <img src="{{ asset('storage/' . $expense->img) }}" alt="Receipt" style="width:50px; height:50px; object-fit:cover; border-radius:4px; border:1px solid #ddd;">
                        @else
                            <div style="width:50px; height:50px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; border-radius:4px; font-size:10px; color:#888;">No Img</div>
                        @endif
                    </td>
                    <td>{{ $expense->name }}</td>
                    <td>${{ number_format($expense->amount, 2) }}</td>
                    <td>{{ $expense->desc }}</td>
                    <td>
                        <span class="badge {{ $expense->status === 'paid' ? 'badge-success' : 'badge-warning' }}" style="padding: 4px 8px; border-radius: 4px; background: {{ $expense->status === 'paid' ? '#28a745' : '#ffc107' }}; color: {{ $expense->status === 'paid' ? '#fff' : '#000' }}; font-size: 12px; display:inline-block;">
                            {{ ucfirst($expense->status) }}
                        </span>
                    </td>
                    <td>{{ $expense->paid_at ? $expense->paid_at->format('Y-m-d H:i') : '-' }}</td>
                    <td>
                        <button class="btn btn-sm btn-secondary" 
                            data-id="{{ $expense->id }}" 
                            data-name="{{ $expense->name }}" 
                            data-amount="{{ $expense->amount }}" 
                            data-desc="{{ $expense->desc }}" 
                            data-status="{{ $expense->status }}" 
                            onclick="editExpense(this)">Edit</button>
                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this expense?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" style="background:#dc3545; color:#fff; border:none; padding:4px 8px; border-radius:4px; cursor:pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($expenses->isEmpty())
                <tr>
                    <td colspan="6" style="text-align:center; padding: 20px;">No expenses found.</td>
                </tr>
                @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Add Expense Modal -->
    <div id="addExpenseModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; padding:20px; border-radius:8px; width:400px; max-width:90%; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
            <h3 style="margin-top:0; border-bottom:1px solid #eee; padding-bottom:10px;">Add Expense</h3>
            <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom:10px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Name</label>
                    <input type="text" name="name" class="input input-sm" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;" required>
                </div>
                <div style="margin-bottom:10px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Amount</label>
                    <input type="number" step="0.01" name="amount" class="input input-sm" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;" required>
                </div>
                <div style="margin-bottom:10px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Description</label>
                    <textarea name="desc" class="input input-sm" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;"></textarea>
                </div>
                <div style="margin-bottom:10px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Receipt Image</label>
                    <input type="file" name="img" accept="image/*" class="input input-sm" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Status</label>
                    <select name="status" class="input input-sm" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;" required>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('addExpenseModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save Expense</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Expense Modal -->
    <div id="editExpenseModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:#fff; padding:20px; border-radius:8px; width:400px; max-width:90%; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
            <h3 style="margin-top:0; border-bottom:1px solid #eee; padding-bottom:10px;">Edit Expense</h3>
            <form id="editExpenseForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="margin-bottom:10px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Name</label>
                    <input type="text" name="name" id="edit_name" class="input input-sm" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;" required>
                </div>
                <div style="margin-bottom:10px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Amount</label>
                    <input type="number" step="0.01" name="amount" id="edit_amount" class="input input-sm" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;" required>
                </div>
                <div style="margin-bottom:10px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Description</label>
                    <textarea name="desc" id="edit_desc" class="input input-sm" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;"></textarea>
                </div>
                <div style="margin-bottom:10px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Receipt Image (Leave blank to keep existing)</label>
                    <input type="file" name="img" accept="image/*" class="input input-sm" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:500;">Status</label>
                    <select name="status" id="edit_status" class="input input-sm" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; box-sizing:border-box;" required>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('editExpenseModal').style.display='none'">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Update Expense</button>
                </div>
            </form>
        </div>
    </div>

</main>

<script>
function editExpense(btn) {
    document.getElementById('edit_name').value = btn.getAttribute('data-name');
    document.getElementById('edit_amount').value = btn.getAttribute('data-amount');
    document.getElementById('edit_desc').value = btn.getAttribute('data-desc');
    document.getElementById('edit_status').value = btn.getAttribute('data-status');
    document.getElementById('editExpenseForm').action = "/expenses/" + btn.getAttribute('data-id');
    document.getElementById('editExpenseModal').style.display = 'flex';
}
</script>
@endsection
