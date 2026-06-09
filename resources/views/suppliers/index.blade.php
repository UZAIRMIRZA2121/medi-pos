@extends('layouts.app')

@section('content')
<main class="page-content">

<!-- SUPPLIERS -->
    <div class="page" id="page-suppliers">
      <div class="card">
        <div class="card-header">
          <h3>Suppliers</h3>
          <div class="header-actions">
            <input type="text" class="input input-sm" id="suppSearch" placeholder="Search suppliers..."/>
            <button class="btn btn-primary btn-sm" onclick="openSuppModal()">+ Add Supplier</button>
          </div>
        </div>
        <div class="table-wrap">
          <table class="table">
            <thead><tr><th>Name</th><th>Company</th><th>Phone</th><th>Email</th><th>Address</th><th>Actions</th></tr></thead>
            <tbody id="suppTbody"></tbody>
          </table>
        </div>
      </div>
    </div>

</main>
@endsection
