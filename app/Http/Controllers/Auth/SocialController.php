<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    // Redirect the user to the provider (Google or Facebook)
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Handle the callback after user authenticates
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Check if the user already exists in your database
            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {
                // If they don't exist, create them
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt(uniqid()), // Random password
                ]);
            }

            // Log them in
            Auth::login($user);

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['error' => 'Unable to login with ' . $provider]);
        }
    }
}