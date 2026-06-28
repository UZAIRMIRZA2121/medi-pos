<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class GoogleLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        Log::info('Redirecting to Google for authentication.');
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            Log::info('Google callback hit. Attempting to retrieve user from Google.');
            $googleUser = Socialite::driver('google')->user();
            
            Log::info('Successfully retrieved Google user.', [
                'id' => $googleUser->id,
                'email' => $googleUser->email,
                'name' => $googleUser->name
            ]);

            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                Log::info('Existing user found with google_id. Logging in.', ['user_id' => $user->id]);
                Auth::login($user);
                return $this->redirectUser($user);
            } else {
                Log::info('No user found with google_id. Checking by email.', ['email' => $googleUser->email]);
                
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    Log::info('User found by email. Updating google_id and logging in.', ['user_id' => $existingUser->id]);
                    
                    $existingUser->update([
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                    ]);
                    Auth::login($existingUser);
                    return $this->redirectUser($existingUser);
                }

                Log::info('No existing user found. Creating new user.');
                
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'type' => 'store', // Default type
                    'password' => bcrypt(Str::random(16)), 
                ]);

                Log::info('New user created successfully. Logging in.', ['user_id' => $newUser->id]);
                
                Auth::login($newUser);
                return $this->redirectUser($newUser);
            }

        } catch (\Exception $e) {
            Log::error('Error occurred in Google Callback.', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect('/login')->with('error', 'Failed to authenticate with Google. Error: ' . $e->getMessage());
        }
    }

    /**
     * Determine redirect route based on user type.
     */
    private function redirectUser($user)
    {
        if ($user->type === 'admin') {
            return redirect()->intended(route('admin.users.index', absolute: false));
        }
        if ($user->type === 'seller') {
            return redirect()->intended(route('seller.dashboard', absolute: false));
        }
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
