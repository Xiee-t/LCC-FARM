<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            
            // Set session data
            Session::put([
                'user_logged_in' => true,
                'user_name' => $user->getName(),
                'user_identity' => $user->getEmail(),
                'user_role' => 'buyer', // Default new social logins to buyer
            ]);

            return redirect()->route('buyer-dashboard')->with('success', 'Logged in successfully!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to login via ' . $provider);
        }
    }
}