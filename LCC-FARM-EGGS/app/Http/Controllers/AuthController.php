<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        // For demo purposes, let's create a simple authentication
        // In a real app, you'd check against the database
        $phone = $request->input('phone');
        $password = $request->input('password');

        // Simple demo authentication - accept any phone/password combination
        if (!empty($phone) && !empty($password)) {
            // Create a session to simulate login
            $registered = session('user_registration');
            $role = $registered['role'] ?? 'buyer';

            session([
                'user_logged_in' => true,
                'user_phone' => $phone,
                'user_role' => $role,
            ]);

            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['login' => 'Invalid credentials']);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'role' => 'required|in:buyer,distributor,supplier',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'phone' => 'required|string',
            'month' => 'required|digits:2',
            'day' => 'required|digits:2',
            'year' => 'required|digits:4',
        ]);

        // For demo purposes, store registration values in session
        session(['user_registration' => [
            'role' => $request->input('role'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'dob' => $request->input('month') . '/' . $request->input('day') . '/' . $request->input('year'),
        ]]);

        return redirect()->route('login')->with('success', 'Account created successfully! Please login.');
    }

    public function dashboard()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        return view('pages.dashboard', [
            'phone' => session('user_phone'),
            'role' => session('user_role', 'buyer'),
        ]);
    }

    public function logout()
    {
        session()->forget(['user_logged_in', 'user_phone', 'user_role']);
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    public function placeOrder()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to place an order.');
        }

        return view('pages.place_order');
    }

    public function viewOrders()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        return view('pages.view_orders');
    }
}