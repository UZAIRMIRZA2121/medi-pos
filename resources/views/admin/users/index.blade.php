@extends('layouts.app')

@section('content')
<main class="page-content">

    <!-- USERS -->
    <div class="page" id="page-admin-users">
        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3>User Management</h3>
                <div class="header-actions">
                    <input type="text" class="input input-sm" id="userSearch" placeholder="Search users..."/>
                </div>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Package</th>
                            <th>Sub Status</th>
                            <th>Parent User</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTbody">
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span style="padding: 2px 8px; border-radius: 12px; font-size: 0.85em; background: {{ $user->type === 'admin' ? '#ffebee' : '#e3f2fd' }}; color: {{ $user->type === 'admin' ? '#c62828' : '#1565c0' }};">
                                    {{ ucfirst($user->type) }}
                                </span>
                            </td>
                            <td>{{ $user->package ? $user->package->name : ($user->package_id ?? '-') }}</td>
                            <td>
                                @php
                                    $sub = $user->subscriptions->last();
                                @endphp
                                @if($sub)
                                    <label class="switch" style="vertical-align: middle;">
                                        <input type="checkbox" onchange="toggleSubscription({{ $user->id }}, this)" {{ $sub->status === 'active' ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                @else
                                    <span style="font-size: 0.8rem; color: #888;">No Sub</span>
                                @endif
                            </td>
                            <td>{{ $user->parent ? $user->parent->name : ($user->parent_id ?? '-') }}</td>
                            <td>
                                <button class="btn btn-ghost btn-sm" onclick="openEditUserModal({{ json_encode($user) }})">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

<!-- Edit User Modal -->
<div class="modal-overlay hidden" id="editUserModalOverlay">
  <div class="modal" style="max-width: 500px;">
    <div class="modal-header">
      <h3 id="editUserModalTitle">Edit User</h3>
      <button class="modal-close" onclick="closeEditUserModal()">×</button>
    </div>
    <div class="modal-body">
      <form id="editUserForm" method="POST" action="">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" id="editUserName" class="input" required/>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" id="editUserEmail" class="input" required/>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="type" id="editUserType" class="input" required>
              <option value="admin">Admin</option>
              <option value="store">Store</option>
              <option value="pharmacist">Pharmacist</option>
              <option value="cashier">Cashier</option>
            </select>
          </div>
          <div class="form-group">
            <label>Package</label>
            <select name="package_id" id="editUserPackageId" class="input">
              <option value="">None</option>
              @foreach($packages as $package)
                  <option value="{{ $package->id }}">{{ $package->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Parent ID</label>
            <input type="number" name="parent_id" id="editUserParentId" class="input"/>
          </div>
          <div class="form-group form-full">
            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="password" minlength="8" class="input"/>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeEditUserModal()">Cancel</button>
      <button class="btn btn-primary" onclick="document.getElementById('editUserForm').submit()">Save Changes</button>
    </div>
  </div>
</div>

<script>
    function openEditUserModal(user) {
        document.getElementById('editUserForm').action = '/admin/users/' + user.id;
        document.getElementById('editUserName').value = user.name;
        document.getElementById('editUserEmail').value = user.email;
        document.getElementById('editUserType').value = user.type;
        document.getElementById('editUserPackageId').value = user.package_id || '';
        document.getElementById('editUserParentId').value = user.parent_id || '';
        
        document.getElementById('editUserModalOverlay').classList.remove('hidden');
    }

    function closeEditUserModal() {
        document.getElementById('editUserModalOverlay').classList.add('hidden');
    }

    // Simple search filtering
    document.getElementById('userSearch').addEventListener('input', function(e) {
        let term = e.target.value.toLowerCase();
        let rows = document.querySelectorAll('#userTbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });

    function toggleSubscription(userId, checkbox) {
        fetch(`/admin/users/${userId}/toggle-subscription`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // optionally show a toast notification here
                console.log(data.message);
            } else {
                alert(data.message || 'Error updating subscription');
                checkbox.checked = !checkbox.checked; // Revert
            }
        })
        .catch(err => {
            console.error(err);
            alert('An error occurred.');
            checkbox.checked = !checkbox.checked; // Revert
        });
    }
</script>

<style>
/* Simple Toggle Switch CSS */
.switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 22px;
}
.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: .4s;
}
.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .4s;
}
input:checked + .slider {
  background-color: #4f46e5;
}
input:checked + .slider:before {
  transform: translateX(18px);
}
.slider.round {
  border-radius: 22px;
}
.slider.round:before {
  border-radius: 50%;
}
</style>
@endsection
