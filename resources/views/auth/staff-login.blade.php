<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" style="color: var(--success); text-align: center; font-size: 13px; margin-bottom: 10px;" />

    <div class="card-header" style="border-bottom: none; padding-bottom: 0;">
        <h3 style="font-size: 18px; text-align: center; width: 100%; margin-bottom: 10px;">Staff Login</h3>
    </div>

    <form method="POST" action="{{ route('staff.login.submit') }}" class="form-grid" style="display: flex; flex-direction: column; gap: 16px;">
        @csrf

        <!-- Email Address -->
        <div class="form-group form-full">
            <label for="email">Staff Email</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" style="color: var(--danger); font-size: 12px;" />
        </div>

        <!-- OTP -->
        <div class="form-group form-full">
            <label for="otp">4-Digit OTP</label>
            <input id="otp" class="input" type="text" name="otp" required autocomplete="off" maxlength="4" style="letter-spacing: 4px; font-weight: bold; text-align: center; font-size: 1.2rem;" />
            <x-input-error :messages="$errors->get('otp')" style="color: var(--danger); font-size: 12px;" />
        </div>

        <div class="form-actions" style="margin-top: 10px; display: flex; flex-direction: column; gap: 12px;">
            <button type="submit" class="btn btn-primary btn-full" style="padding: 10px 0; font-size: 14px;">
                {{ __('Log in') }}
            </button>

            <div style="display: flex; justify-content: center; align-items: center; font-size: 13px;">
                <a href="{{ route('login') }}" style="color: var(--primary);">Back to Store Login</a>
            </div>
        </div>
    </form>
</x-guest-layout>
