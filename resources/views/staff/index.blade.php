@extends('layouts.app')

@section('content')
<main class="page-content">

<!-- STAFF -->
    <div class="page" id="page-staff">
      <div class="card">
        <div class="card-header">
          <h3>Staff Management</h3>
          <div class="header-actions">
            <input type="text" class="input input-sm" id="staffSearch" placeholder="Search staff..."/>
            <button class="btn btn-primary btn-sm" onclick="openStaffModal()">+ Add Staff</button>
          </div>
        </div>
        <div class="table-wrap">
          <table class="table">
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Privileges</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody id="staffTbody"></tbody>
          </table>
        </div>
      </div>
    </div>

</main>
@endsection
