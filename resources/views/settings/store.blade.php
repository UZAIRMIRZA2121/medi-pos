@extends('layouts.app')

@section('content')
<main class="page-content">
  <div class="page" id="page-store-settings">
    
    <div style="max-width: 600px; margin: 0 auto; margin-bottom: 20px;">
        <div class="tabs" style="display: flex; gap: 20px; border-bottom: 1px solid #e2e8f0;">
            <button class="tab-btn active" onclick="switchTab('store')" id="btn-store" style="padding: 10px 15px; background: none; border: none; border-bottom: 2px solid #0066cc; cursor: pointer; font-weight: 500; color: #0066cc; font-size: 14px;">Store Settings</button>
            <button class="tab-btn" onclick="switchTab('invoice')" id="btn-invoice" style="padding: 10px 15px; background: none; border: none; border-bottom: 2px solid transparent; cursor: pointer; font-weight: 500; color: #64748b; font-size: 14px;">Invoice Print Settings</button>
        </div>
    </div>

    <!-- Store Settings Tab -->
    <div id="tab-store" class="tab-content" style="display: block;">
        <div class="card" style="max-width: 600px; margin: 0 auto;">
          <div class="card-body" style="padding: 20px;">
            @if(session('success') && !session('invoice_success'))
              <div class="alert alert-success" style="padding: 10px; background: #d1fae5; color: #065f46; border-radius: 6px; margin-bottom: 20px;">
                {{ session('success') }}
              </div>
            @endif

            <form action="{{ route('settings.store.store') }}" method="POST">
              @csrf
              <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                <div class="form-group" style="flex: 1;">
                  <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Tax (%)</label>
                  <input type="number" name="tax" class="input w-full" value="{{ old('tax', $settings->tax) }}" min="0" max="100" step="0.01" required>
                  @error('tax')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group" style="flex: 1;">
                  <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Default Discount (%)</label>
                  <input type="number" name="discount" class="input w-full" value="{{ old('discount', $settings->discount) }}" min="0" max="100" step="0.01" required>
                  @error('discount')
                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="form-group" style="margin-bottom: 25px;">
                <label style="display: flex; align-items: center; gap: 8px; font-weight: 500; cursor: pointer; text-transform: uppercase; font-size: 12px; color: #64748b;">
                  <div class="custom-toggle">
                    <input type="checkbox" name="auto_print" value="1" {{ old('auto_print', $settings->auto_print) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                  </div>
                  Auto Print Thermal Receipt
                </label>
              </div>

              <button type="submit" class="btn btn-primary" style="width: 100%;">Save Store Settings</button>
            </form>
          </div>
        </div>
    </div>
    
    <!-- Invoice Settings Tab -->
    <div id="tab-invoice" class="tab-content" style="display: none;">
        <div class="card" style="max-width: 600px; margin: 0 auto;">
          <div class="card-body" style="padding: 20px;">
              @if(session('success') && session('invoice_success'))
                  <div class="alert alert-success" style="padding: 10px; background: #d1fae5; color: #065f46; border-radius: 6px; margin-bottom: 20px;">
                      {{ session('success') }}
                  </div>
              @endif
              
              <form method="POST" action="{{ route('settings.print.store') }}" enctype="multipart/form-data">
                  @csrf
                  
                  <div class="form-group" style="margin-bottom: 15px;">
                      <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Store Name (for invoice)</label>
                      <input type="text" name="name" class="input w-full" value="{{ $printSetting->name ?? '' }}">
                  </div>
                  
                  <div class="form-group" style="margin-bottom: 15px;">
                      <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Store Description / Tagline</label>
                      <textarea name="desc" class="input w-full" rows="2">{{ $printSetting->desc ?? '' }}</textarea>
                  </div>

                  <div class="form-group" style="margin-bottom: 15px;">
                      <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Store Address</label>
                      <textarea name="address" class="input w-full" rows="2">{{ $printSetting->address ?? '' }}</textarea>
                  </div>

                  <div class="form-group" style="margin-bottom: 15px;">
                      <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Invoice Heading</label>
                      <input type="text" name="heading" class="input w-full" value="{{ $printSetting->heading ?? 'INVOICE' }}">
                  </div>
                  
                  <div class="form-group" style="margin-bottom: 15px;">
                      <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Footer Text (Terms & Conditions)</label>
                      <textarea name="footer" class="input w-full" rows="3">{{ $printSetting->footer ?? '' }}</textarea>
                  </div>

                  <div class="form-group" style="margin-bottom: 20px;">
                      <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Logo</label>
                      @if(isset($printSetting) && $printSetting->logo)
                          <div style="margin-bottom: 10px;">
                              <img src="{{ $printSetting->logo }}" alt="Logo" style="max-height: 50px;">
                          </div>
                      @endif
                      <input type="file" name="logo" class="input w-full" accept="image/*">
                  </div>

                  <button type="submit" class="btn btn-primary" style="width: 100%;">Save Invoice Settings</button>
              </form>
          </div>
        </div>
    </div>

  </div>
</main>

<script>
function switchTab(tab) {
    document.getElementById('tab-store').style.display = 'none';
    document.getElementById('tab-invoice').style.display = 'none';
    
    document.getElementById('btn-store').style.borderBottomColor = 'transparent';
    document.getElementById('btn-store').style.color = '#64748b';
    
    document.getElementById('btn-invoice').style.borderBottomColor = 'transparent';
    document.getElementById('btn-invoice').style.color = '#64748b';
    
    document.getElementById('tab-' + tab).style.display = 'block';
    document.getElementById('btn-' + tab).style.borderBottomColor = '#0066cc';
    document.getElementById('btn-' + tab).style.color = '#0066cc';
}

// Optional: check if we should show invoice tab after submit
@if(session('invoice_success'))
    switchTab('invoice');
@endif
</script>
@endsection
