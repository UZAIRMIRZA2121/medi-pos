<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>MediPoint POS — Medical Store Management</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

    @include('partials.sidebar')
    
    <!-- OVERLAY -->
    <div class="overlay" id="overlay"></div>
    
    <!-- MAIN -->
    <div class="main-wrapper">
        @include('partials.topbar')
        
        @yield('content')
        {{ $slot ?? '' }}
    </div>
    
    @include('partials.modals')
    
<div class="toast-container" id="toastContainer"></div>

@php
    $printSetting = null;
    if (Auth::check()) {
        $printSetting = \App\Models\PrintSetting::first();
    }
@endphp
<script>
    window.printSettings = {
        name: {!! json_encode($printSetting->name ?? 'MediPoint Pharmacy') !!},
        desc: {!! json_encode($printSetting->desc ?? "Shop #12, Main Market") !!},
        address: {!! json_encode($printSetting->address ?? "Faisalabad, Punjab, Pakistan\nPh: 041-1234567") !!},
        heading: {!! json_encode($printSetting->heading ?? 'INVOICE') !!},
        footer: {!! json_encode($printSetting->footer ?? "*** Thank You! ***\nGet well soon. Visit again.\nKeep medicines away from children.\nStore as directed on packaging.") !!},
        logo: {!! json_encode($printSetting->logo ?? null) !!}
    };
</script>

<script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
