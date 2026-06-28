<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
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
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // If user exists with google_id, log them in
                Auth::login($user);
                return redirect()->intended('/home');
            } else {
                // Check if user exists with the same email
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    // Update existing user with google_id
                    $existingUser->update([
                        'google_id' => $googleUser->id,
                        'google_token' => $googleUser->token,
                        'google_refresh_token' => $googleUser->refreshToken,
                    ]);
                    Auth::login($existingUser);
                    return redirect()->intended('/home');
                }

                // If user doesn't exist at all, create a new user
                // You can also assign a default role if your app requires it (e.g., 'type' => 'store')
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'type' => 'store', // Default type
                    'password' => bcrypt(Str::random(16)), 
                ]);

                Auth::login($newUser);
                return redirect()->intended('/home');
            }

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Failed to authenticate with Google.');
        }
    }
}
