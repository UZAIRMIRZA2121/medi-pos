@extends('layouts.app')

@section('content')
<main class="page-content">

<!-- MEDICINES -->
    <div class="page" id="page-medicines">
      <div class="card">
        <div class="card-header">
          <h3>Medicine Inventory</h3>
          <div class="header-actions">
            <input type="text" class="input input-sm" id="medSearch" placeholder="Search medicines..."/>
            <select class="input input-sm" id="medCatFilter"><option value="">All Categories</option></select>
            <button class="btn btn-primary btn-sm" onclick="openMedModal()">+ Add Medicine</button>
          </div>
        </div>
        <div class="table-wrap">
          <table class="table">
            <thead><tr><th>Name</th><th>Generic</th><th>Category</th><th>Company</th><th>Batch</th><th>Sale Price</th><th>Stock</th><th>Expiry</th><th>Rx</th><th>Actions</th></tr></thead>
            <tbody id="medTbody"></tbody>
          </table>
        </div>
      </div>
    </div>

</main>
@endsection
