<x-guest-layout>
    <div class="card-header" style="border-bottom: none; padding-bottom: 0;">
        <h3 style="font-size: 18px; text-align: center; width: 100%; margin-bottom: 10px;">Create an Account</h3>
    </div>

    <form method="POST" action="{{ route('register') }}" class="form-grid" style="display: flex; flex-direction: column; gap: 16px;">
        @csrf

        @if(isset($ref_id))
            <input type="hidden" name="ref_id" value="{{ $ref_id }}">
        @endif
        @if(isset($package_id))
            <input type="hidden" name="package_id" value="{{ $package_id }}">
        @endif

        <!-- Name -->
        <div class="form-group form-full">
            <label for="name">Name *</label>
            <input id="name" class="input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" style="color: var(--danger); font-size: 12px;" />
        </div>

        <!-- Email Address -->
        <div class="form-group form-full">
            <label for="email">Email *</label>
            <input id="email" class="input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" style="color: var(--danger); font-size: 12px;" />
        </div>

        <!-- Password -->
        <div class="form-group form-full">
            <label for="password">Password *</label>
            <input id="password" class="input" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" style="color: var(--danger); font-size: 12px;" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group form-full">
            <label for="password_confirmation">Confirm Password *</label>
            <input id="password_confirmation" class="input" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" style="color: var(--danger); font-size: 12px;" />
        </div>

        <div class="form-actions" style="margin-top: 10px; display: flex; flex-direction: column; gap: 12px;">
            <button type="submit" name="type" value="store" class="btn btn-primary btn-full" style="padding: 10px 0; font-size: 14px;">
                {{ __('Register as Store') }}
            </button>
            <!--
            <button type="submit" name="type" value="seller" class="btn btn-full" style="padding: 10px 0; font-size: 14px; background: rgba(79,70,229,0.1); border: 1px solid #4f46e5; color: #4f46e5;">
                {{ __('Register as Seller') }}
            </button>
            -->
            
            <a href="{{ route('google.login') }}" class="btn btn-full" style="padding: 10px 0; font-size: 14px; background: white; border: 1px solid #d1d5db; color: #374151; display: flex; align-items: center; justify-content: center; gap: 8px;">
                <svg style="width: 18px; height: 18px;" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Register with Google
            </a>

            <a class="btn btn-ghost btn-full" href="{{ route('login') }}" style="text-align: center;">
                {{ __('Already registered? Log in') }}
            </a>
        </div>
    </form>
</x-guest-layout>
