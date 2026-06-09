@extends('layouts.app')

@section('content')
<main class="page-content">

<!-- CATEGORIES -->
    <div class="page" id="page-categories">
      <div class="page-half">
        <div class="card">
          <div class="card-header"><h3 id="catFormTitle">Add Category</h3></div>
          <div class="form-body">
            <input type="hidden" id="catEditId"/>
            <div class="form-group"><label>Category Name *</label><input type="text" id="catName" class="input" placeholder="e.g. Antibiotics"/></div>
            <div class="form-group"><label>Description</label><textarea id="catDesc" class="input" rows="2" placeholder="Optional description..."></textarea></div>
            <div class="form-group"><label>Color Tag</label><input type="color" id="catColor" class="input" value="#00b4d8" style="width:60px;height:40px;padding:4px;cursor:pointer"/></div>
            <div class="form-actions">
              <button class="btn btn-primary" onclick="saveCategory()">Save Category</button>
              <button class="btn btn-ghost" onclick="resetCatForm()">Reset</button>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3>Categories</h3>
            <input type="text" class="input input-sm" id="catSearch" placeholder="Search..."/>
          </div>
          <div class="table-wrap">
            <table class="table">
              <thead><tr><th>Color</th><th>Name</th><th>Description</th><th>Medicines</th><th>Actions</th></tr></thead>
              <tbody id="catTbody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

</main>
@endsection
