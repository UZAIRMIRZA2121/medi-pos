@extends('layouts.app')

@section('content')
<main class="page-content">
    <div class="page" id="page-profile">
        
        <div class="card" style="max-width: 600px; margin: 0 auto; margin-bottom: 20px;">
            <div class="card-header">
                <h3>Profile Information</h3>
            </div>
            <div class="card-body" style="padding: 20px;">
                <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 20px;">
                    Update your account's profile information and email address.
                </p>
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Name</label>
                        <input type="text" name="name" class="input w-full" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span style="color: red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Email</label>
                        <input type="email" name="email" class="input w-full" value="{{ old('email', $user->email) }}" required readonly style="background-color: #f8fafc; cursor: not-allowed; color: #64748b;">
                        @error('email')
                            <span style="color: red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Save Changes</button>
                    @if (session('status') === 'profile-updated')
                        <p style="color: green; font-size: 13px; margin-top: 10px; text-align: center;">Saved.</p>
                    @endif
                </form>
            </div>
        </div>

        @if(Auth::id() != 2)
        <div class="card" style="max-width: 600px; margin: 0 auto; margin-bottom: 20px;">
            <div class="card-header">
                <h3>Update Password</h3>
            </div>
            <div class="card-body" style="padding: 20px;">
                <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 20px;">
                    Ensure your account is using a long, random password to stay secure.
                </p>
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Current Password</label>
                        <input type="password" name="current_password" class="input w-full" required>
                        @error('current_password', 'updatePassword')
                            <span style="color: red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">New Password</label>
                        <input type="password" name="password" class="input w-full" required>
                        @error('password', 'updatePassword')
                            <span style="color: red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 25px;">
                        <label style="display: block; font-weight: 500; margin-bottom: 5px; text-transform: uppercase; font-size: 12px; color: #64748b;">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="input w-full" required>
                        @error('password_confirmation', 'updatePassword')
                            <span style="color: red; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Save Password</button>
                    @if (session('status') === 'password-updated')
                        <p style="color: green; font-size: 13px; margin-top: 10px; text-align: center;">Saved.</p>
                    @endif
                </form>
            </div>
        </div>
        @endif
        
    </div>
</main>
@endsection
