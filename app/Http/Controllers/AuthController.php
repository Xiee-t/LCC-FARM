<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    // --- Dashboard & Profile Routing ---
    
    public function dashboard()
    {
        $user = Auth::user();
        if ($user) {
            $role = $user->role ?? $this->determineRole($user);
            $routeName = $role . '-dashboard';
            if (!empty($role) && Route::has($routeName)) {
                return redirect()->route($routeName);
            }
            return redirect()->route('buyer-dashboard');
        }
        return redirect()->route('landing');
    }

    private function determineRole(User $user)
    {
        $email = strtolower($user->email);
        if (str_contains($email, 'distributor')) return 'distributor';
        if (str_contains($email, 'supplier')) return 'supplier';
        return 'buyer';
    }

    public function profile()
    {
        if (!Auth::check()) return redirect()->route('login');
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

    public function showLogin()
    {
        return view('pages.login');
    }

    public function login(Request $request)
    {
        $loginField = $request->input('login');
        $password = $request->input('password');

        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        // Try as email or phone
        $credentials = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? ['email' => $loginField, 'password' => $password] : ['phone' => $loginField, 'password' => $password];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $userRole = $this->determineRole(Auth::user());
            session([
                'user_logged_in' => true,
                'user_role' => $userRole,
                'user_identity' => Auth::user()->email,
            ]);
            return redirect()->route($userRole . '-dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }

    public function showRegister()
    {
        return view('pages.signup');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:buyer,supplier,distributor'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        session([
            'user_logged_in' => true,
            'user_role' => $validated['role'],
            'user_identity' => $user->email,
        ]);

        return redirect()->route($validated['role'] . '-dashboard')->with('success', 'Registration successful!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    }

    // --- Order Logic ---

    public function buyerDashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('pages.buyer_dashboard');
    }

    public function placeOrder()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('pages.place_order');
    }

    public function myOrders()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $orders = session('user_orders', []);
        return view('pages.my_orders', ['orders' => $orders]);
    }

    public function orderDetails($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('pages.order_details', ['id' => $id]);
    }

    public function storeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
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

