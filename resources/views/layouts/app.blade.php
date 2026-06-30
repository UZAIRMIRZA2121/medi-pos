<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>MediPos POS — Medical Store Management</title>
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ filemtime(public_path('assets/css/style.css')) }}">
</head>
<body class="{{ request()->routeIs('pos.index') ? 'pos-fullscreen' : '' }}">

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
        name: {!! json_encode($printSetting->name ?? 'MediPos Pharmacy') !!},
        desc: {!! json_encode($printSetting->desc ?? "Shop #12, Main Market") !!},
        address: {!! json_encode($printSetting->address ?? "Faisalabad, Punjab, Pakistan\nPh: 041-1234567") !!},
        heading: {!! json_encode($printSetting->heading ?? 'INVOICE') !!},
        footer: {!! json_encode($printSetting->footer ?? "*** Thank You! ***\nGet well soon. Visit again.") !!},
        logo: {!! json_encode($printSetting->logo ?? null) !!}
    };
</script>

<!-- WhatsApp Floating Button -->
<a href="https://wa.me/923086452242?text={{ urlencode('Hello MediPOS Support Team, I need some help.') }}" 
   target="_blank" 
   class="whatsapp-float-btn" 
   aria-label="Chat with us on WhatsApp">
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.005-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
    </svg>
</a>

<style>
.whatsapp-float-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: #25d366;
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
    z-index: 9999;
    text-decoration: none;
    transition: all 0.3s ease;
}
.whatsapp-float-btn:hover {
    background-color: #128c7e;
    color: white;
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
}
/* If it's on pos screen (which is fullscreen), you might want to adjust or hide it */
body.pos-fullscreen .whatsapp-float-btn {
    bottom: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
}
body.pos-fullscreen .whatsapp-float-btn svg {
    width: 24px;
    height: 24px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Core JS -->
    <script src="{{ asset('assets/js/script.js') }}?v={{ time() }}"></script>
</body>
</html>
