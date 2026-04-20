<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{
    // --- Dashboard & Profile Routing ---
    
    public function dashboard()
    {
        if (!session()->has('user_logged_in')) return redirect()->route('login');
        return redirect()->route(session('user_role', 'buyer') . '-dashboard');
    }

    public function profile()
    {
        if (!session()->has('user_logged_in')) return redirect()->route('login');
        return view('pages.profile');
    }

    // --- Authentication & Socialite ---

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();

            session([
                'user_logged_in' => true,
                'user_role' => 'buyer',
                'user_identity' => $user->getEmail(),
                'user_name' => $user->getName(),
            ]);

            return redirect()->route('buyer-dashboard');
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Login Failed: ' . $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $request->validate(['login' => 'required', 'password' => 'required']);
        
        session(['user_logged_in' => true, 'user_role' => 'buyer', 'user_identity' => $request->login]);
        return redirect()->route('buyer-dashboard');
    }

    public function signup(Request $request)
    {
        $request->validate(['role' => 'required', 'email' => 'required']);
        session(['user_logged_in' => true, 'user_role' => $request->role, 'user_identity' => $request->email]);
        return redirect()->route($request->role . '-dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('landing');
    }

    // --- Order Logic ---

    public function buyerDashboard()
    {
        if (!session('user_logged_in')) return redirect()->route('login');
        return view('pages.buyer_dashboard');
    }

    public function placeOrder()
    {
        return view('pages.place_order');
    }

    public function myOrders()
    {
        if (!session('user_logged_in')) return redirect()->route('login');
        
        $orders = session('user_orders', []);
        return view('pages.my_orders', ['orders' => $orders]);
    }

    public function orderDetails($id)
    {
        return view('pages.order_details', ['id' => $id]);
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'egg_size' => 'required', 
            'quantity' => 'required|integer', 
            'address' => 'required'
        ]);
        
        $orders = session('user_orders', []);
        $orders[] = [
            'id' => rand(1000,9999), 
            'product' => $request->egg_size,
            'status' => 'Processing'
        ];
        
        session(['user_orders' => $orders]);

        return redirect()->route('my-orders')->with('success', 'Order placed successfully!');
    }
}