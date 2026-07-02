<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            
            // Try Cloud Verification Fallback
            $cloudVerified = false;
            try {
                $apiUrl = config('app.cloud_api_url', 'http://127.0.0.1:8000/api');
                $response = \Illuminate\Support\Facades\Http::post($apiUrl . '/sync/verify-login', [
                    'email' => $this->email,
                    'password' => $this->password,
                ]);

                if ($response->successful() && $response->json('status') === 'success') {
                    $userData = $response->json('user');
                    
                    // User exists on cloud! Create them locally.
                    $user = \App\Models\User::create([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => $userData['password'], // already hashed
                    ]);

                    // Force an immediate initial sync pull to download their data
                    \Illuminate\Support\Facades\Artisan::call('sync:run');

                    Auth::login($user, $this->boolean('remember'));
                    $cloudVerified = true;
                }
            } catch (\Exception $e) {
                // Ignore API connection failures and just fallback to standard error
            }

            if (!$cloudVerified) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
