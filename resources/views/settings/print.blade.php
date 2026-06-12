@extends('layouts.app')

@section('content')
<main class="page-content">
    <div class="page">
        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header">
                <h3>Invoice Print Settings</h3>
            </div>
            <div class="card-body" style="padding: 20px;">
                @if(session('success'))
                    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                        {{ session('success') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('settings.print.store') }}" enctype="multipart/form-data" class="form-grid">
                    @csrf
                    
                    <div class="form-group form-full">
                        <label>Store Name (for invoice)</label>
                        <input type="text" name="name" class="input" value="{{ $setting->name ?? '' }}">
                    </div>
                    
                    <div class="form-group form-full">
                        <label>Store Description / Tagline</label>
                        <textarea name="desc" class="input" rows="2">{{ $setting->desc ?? '' }}</textarea>
                    </div>

                    <div class="form-group form-full">
                        <label>Store Address</label>
                        <textarea name="address" class="input" rows="2">{{ $setting->address ?? '' }}</textarea>
                    </div>

                    <div class="form-group form-full">
                        <label>Invoice Heading</label>
                        <input type="text" name="heading" class="input" value="{{ $setting->heading ?? 'INVOICE' }}">
                    </div>
                    
                    <div class="form-group form-full">
                        <label>Footer Text (Terms & Conditions)</label>
                        <textarea name="footer" class="input" rows="3">{{ $setting->footer ?? '' }}</textarea>
                    </div>

                    <div class="form-group form-full">
                        <label>Logo</label>
                        @if(isset($setting) && $setting->logo)
                            <div style="margin-bottom: 10px;">
                                <img src="{{ $setting->logo }}" alt="Logo" style="max-height: 50px;">
                            </div>
                        @endif
                        <input type="file" name="logo" class="input" accept="image/*">
                    </div>

                    <div class="form-actions" style="margin-top: 10px;">
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
