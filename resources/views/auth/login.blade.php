<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" style="color: var(--success); text-align: center; font-size: 13px; margin-bottom: 10px;" />

    <div class="card-header" style="border-bottom: none; padding-bottom: 0;">
        <h3 style="font-size: 18px; text-align: center; width: 100%; margin-bottom: 10px;">Log in to your account</h3>
    </div>

    <form method="POST" action="{{ route('login') }}" class="form-grid" style="display: flex; flex-direction: column; gap: 16px;">
        @csrf

        <!-- Email Address -->
        <div class="form-group form-full">
            <label for="email">Email</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" style="color: var(--danger); font-size: 12px;" />
        </div>

        <!-- Password -->
        <div class="form-group form-full">
            <label for="password">Password</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" style="color: var(--danger); font-size: 12px;" />
        </div>

        <!-- Remember Me -->
        <div class="form-group form-full" style="flex-direction: row; align-items: center; gap: 8px;">
            <input id="remember_me" type="checkbox" name="remember" style="width: 16px; height: 16px;">
            <label for="remember_me" style="text-transform: none; letter-spacing: normal;">Remember me</label>
        </div>

        <div class="form-actions" style="margin-top: 10px; display: flex; flex-direction: column; gap: 12px;">
            <button type="submit" class="btn btn-primary btn-full" style="padding: 10px 0; font-size: 14px;">
                {{ __('Log in') }}
            </button>

            <a href="{{ route('google.login') }}" class="btn btn-full" style="padding: 10px 0; font-size: 14px; background: white; border: 1px solid #d1d5db; color: #374151; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Log in with Google
            </a>
            <a href="{{ route('staff.login') }}" class="btn btn-full" style="padding: 10px 0; font-size: 14px; background: white; border: 1px solid #d1d5db; color: #374151; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Staff Login (OTP)
            </a>

            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px; margin-top: 8px;">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}" style="color: var(--primary);">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <a href="{{ route('register') }}" style="color: var(--primary);">Create account</a>
            </div>
        </div>
    </form>
</x-guest-layout>
