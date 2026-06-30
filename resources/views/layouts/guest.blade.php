<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MediPos POS') }} - Authentication</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>

    <!-- POS Styles -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: var(--bg);
            margin: 0;
        }
        .auth-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 24px;
        }
        .auth-logo .brand-icon {
            display: inline-flex;
            width: 48px;
            height: 48px;
            margin-bottom: 12px;
        }
        .auth-logo .brand-name {
            color: var(--text);
            font-size: 22px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-logo">
            <div class="brand-icon" style="width: 56px; height: 56px; margin: 0 auto 12px;">
                <svg width="56" height="56" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="40" height="40" rx="10" fill="url(#medipos_grad)"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20 28.5L18.75 27.35C14.15 23.18 11 20.35 11 16.85C11 14.02 13.22 11.8 16.05 11.8C17.65 11.8 19.18 12.55 20 13.7C20.82 12.55 22.35 11.8 23.95 11.8C26.78 11.8 29 14.02 29 16.85C29 20.35 25.85 23.18 21.25 27.36L20 28.5Z" fill="white"/>
                    <path d="M12 17.5H15.5L17 14L20.5 22L22.5 17.5H28" stroke="#60A5FA" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs>
                        <linearGradient id="medipos_grad" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#3B82F6"/>
                            <stop offset="1" stop-color="#8B5CF6"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="brand-name" style="font-size: 28px; font-weight: 700; letter-spacing: -0.5px;">Medi<span style="color: #60A5FA;">POS</span></div>
        </div>

        <div class="card">
            <div class="form-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
