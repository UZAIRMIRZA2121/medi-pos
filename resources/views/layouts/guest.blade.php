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
            <div class="brand-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v20M2 12h20"/><circle cx="12" cy="12" r="10"/></svg>
            </div>
            <div class="brand-name">MediPos</div>
        </div>

        <div class="card">
            <div class="form-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
