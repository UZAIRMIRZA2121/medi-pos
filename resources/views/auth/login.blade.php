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

            <div style="display: flex; justify-content: space-between; align-items: center; font-size: 13px;">
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
