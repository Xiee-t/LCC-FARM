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
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // For demo purposes, let's create a simple authentication
        // In a real app, you'd check against the database
        $login = $request->input('login');
        $password = $request->input('password');

        // Determine if login is email or phone
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $userId = 'email';
            $userIdentity = $login;
        } else {
            $userId = 'phone';
            $userIdentity = $login;
        }

        // Simple demo authentication - accept any login/password combination
        if (!empty($userIdentity) && !empty($password)) {
            $registered = session('user_registration');
            $role = $registered['role'] ?? 'buyer';

            session([
                'user_logged_in' => true,
                'user_role' => $role,
                'user_identity' => $userIdentity,
                'user_identity_type' => $userId,
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
            'identity' => session('user_identity'),
            'identity_type' => session('user_identity_type', 'phone'),
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

    public function storeOrder(Request $request)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to place an order.');
        }

        $request->validate([
            'egg_size' => 'required|in:small,medium,large,xl,jumbo',
            'quantity' => 'required|numeric|min:1',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'delivery_date' => 'required|date',
        ]);

        // Store order in session for demo purposes
        $prices = [
            'small' => 230,
            'medium' => 240,
            'large' => 250,
            'xl' => 260,
            'jumbo' => 280,
        ];

        $egg_size = $request->input('egg_size');
        $quantity = (int) $request->input('quantity');
        $unit_price = $prices[$egg_size];
        $subtotal = $unit_price * $quantity;
        $delivery_fee = 50;
        $total = $subtotal + $delivery_fee;

        // Store order in session
        $order_id = 'ORD-' . date('Y') . '-' . rand(100, 999);
        session(['current_order' => [
            'order_id' => $order_id,
            'egg_size' => ucwords(str_replace('_', ' ', $egg_size)),
            'quantity' => $quantity,
            'unit_price' => $unit_price,
            'subtotal' => $subtotal,
            'delivery_fee' => $delivery_fee,
            'total' => $total,
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code'),
            'delivery_date' => $request->input('delivery_date'),
            'order_date' => date('Y-m-d'),
        ]]);

        return redirect()->route('order-confirmation');
    }

    public function viewOrders()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        return view('pages.view_orders');
    }

    public function myOrders()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to view your orders.');
        }

        return view('pages.my_orders');
    }

    public function orderHistory()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to view your order history.');
        }

        return view('pages.order_history');
    }

    public function profile()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to view your profile.');
        }

        return view('pages.profile');
    }
}