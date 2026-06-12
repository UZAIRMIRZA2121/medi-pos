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
            <button type="submit" name="type" value="seller" class="btn btn-full" style="padding: 10px 0; font-size: 14px; background: rgba(79,70,229,0.1); border: 1px solid #4f46e5; color: #4f46e5;">
                {{ __('Register as Seller') }}
            </button>

            <a class="btn btn-ghost btn-full" href="{{ route('login') }}" style="text-align: center;">
                {{ __('Already registered? Log in') }}
            </a>
        </div>
    </form>
</x-guest-layout>
