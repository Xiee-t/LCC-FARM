<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    private function getEggCatalog(): array
    {
        return [
            'small' => ['id' => 'small', 'name' => 'Small (25 Trays)', 'price' => 230, 'stock' => 120],
            'medium' => ['id' => 'medium', 'name' => 'Medium (15 Trays)', 'price' => 240, 'stock' => 90],
            'large' => ['id' => 'large', 'name' => 'Large (10 Trays)', 'price' => 250, 'stock' => 70],
            'xl' => ['id' => 'xl', 'name' => 'XL (5 Trays)', 'price' => 260, 'stock' => 50],
            'jumbo' => ['id' => 'jumbo', 'name' => 'Jumbo (3 Trays)', 'price' => 280, 'stock' => 25],
        ];
    }

    private function buildHistoryOrders(): array
    {
        $history = [];

        foreach (session('user_orders', []) as $order) {
            $sizeKey = strtolower($order['egg_size'] ?? '');
            $completedAtTs = !empty($order['order_date']) ? strtotime($order['order_date']) : time();
            $history[] = [
                'id' => $order['id'] ?? null,
                'order_id' => $order['order_id'] ?? 'N/A',
                'product' => ($order['egg_size'] ?? 'N/A') . ' (' . ($order['quantity'] ?? 0) . ' Trays)',
                'egg_size_key' => $sizeKey,
                'quantity' => (int) ($order['quantity'] ?? 0),
                'total' => (float) ($order['total'] ?? 0),
                'status' => $order['status'] ?? 'Processing',
                'completed_at' => date('M d, Y', $completedAtTs),
                'completed_at_ts' => $completedAtTs,
            ];
        }

        // Fallback demo history to keep the page useful for first-time users.
        $fallback = [
            [
                'id' => null,
                'order_id' => 'ORD-2026-002',
                'product' => 'XL (10 Trays)',
                'egg_size_key' => 'xl',
                'quantity' => 10,
                'total' => 2600,
                'status' => 'Delivered',
                'completed_at' => 'Mar 20, 2026',
                'completed_at_ts' => strtotime('2026-03-20'),
            ],
            [
                'id' => null,
                'order_id' => 'ORD-2026-000',
                'product' => 'Small (20 Trays)',
                'egg_size_key' => 'small',
                'quantity' => 20,
                'total' => 4650,
                'status' => 'Delivered',
                'completed_at' => 'Mar 10, 2026',
                'completed_at_ts' => strtotime('2026-03-10'),
            ],
            [
                'id' => null,
                'order_id' => 'ORD-2025-999',
                'product' => 'Jumbo (5 Trays)',
                'egg_size_key' => 'jumbo',
                'quantity' => 5,
                'total' => 1450,
                'status' => 'Delivered',
                'completed_at' => 'Mar 01, 2026',
                'completed_at_ts' => strtotime('2026-03-01'),
            ],
        ];

        $history = array_merge($history, $fallback);

        usort($history, function ($a, $b) {
            return ($b['completed_at_ts'] ?? 0) <=> ($a['completed_at_ts'] ?? 0);
        });

        return $history;
    }

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

            // Redirect based on role
            if ($role === 'supplier') {
                return redirect()->route('supplier-dashboard')->with('success', 'Login successful!');
            } elseif ($role === 'distributor') {
                return redirect()->route('distributor-dashboard')->with('success', 'Login successful!');
            } else {
                return redirect()->route('buyer-dashboard')->with('success', 'Login successful!');
            }
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

        $role = $request->input('role');

        // For demo purposes, store registration values in session
        session(['user_registration' => [
            'role' => $role,
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'dob' => $request->input('month') . '/' . $request->input('day') . '/' . $request->input('year'),
        ]]);

        // Auto-login after signup
        session([
            'user_logged_in' => true,
            'user_role' => $role,
            'user_identity' => $request->input('email'),
            'user_identity_type' => 'email',
        ]);

        // Redirect to role-specific dashboard
        if ($role === 'supplier') {
            return redirect()->route('supplier-dashboard')->with('success', 'Account created successfully! Welcome to your dashboard.');
        } elseif ($role === 'distributor') {
            return redirect()->route('distributor-dashboard')->with('success', 'Account created successfully! Welcome to your dashboard.');
        } else {
            return redirect()->route('buyer-dashboard')->with('success', 'Account created successfully! Welcome to your dashboard.');
        }
    }

    public function dashboard()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $role = session('user_role');

        if ($role === 'supplier') {
            return redirect()->route('supplier-dashboard');
        } elseif ($role === 'distributor') {
            return redirect()->route('distributor-dashboard');
        } else {
            return redirect()->route('buyer-dashboard');
        }
    }

    public function buyerDashboard()
    {
        if (!session('user_logged_in') || session('user_role') !== 'buyer') {
            return redirect()->route('login')->with('error', 'Please login as a buyer.');
        }

        $products = array_values($this->getEggCatalog());
        $userOrders = session('user_orders', []);

        return view('pages.buyer_dashboard', [
            'identity' => session('user_identity'),
            'role' => session('user_role'),
            'products' => $products,
            'activeOrderCount' => count($userOrders),
            'historyOrderCount' => count($this->buildHistoryOrders()),
            'totalStock' => array_sum(array_column($products, 'stock')),
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

        return view('pages.place_order', [
            'products' => array_values($this->getEggCatalog()),
            'prefill' => [
                'egg_size' => request('size'),
                'quantity' => request('qty', 1),
                'address' => request('address', ''),
                'city' => request('city', ''),
                'postal_code' => request('postal_code', ''),
                'delivery_date' => request('delivery_date', ''),
            ],
        ]);
    }

    public function storeOrder(Request $request)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to place an order.');
        }

        $request->validate([
            'egg_size' => 'required|in:small,medium,large,xl,jumbo',
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'delivery_date' => 'required|date',
        ]);

        // Store order in session for demo purposes
        $catalog = $this->getEggCatalog();
        $prices = array_column($catalog, 'price', 'id');

        $egg_size = $request->input('egg_size');
        $quantity = (int) $request->input('quantity');
        $unit_price = $prices[$egg_size];
        $subtotal = $unit_price * $quantity;
        $delivery_fee = 50;
        $total = $subtotal + $delivery_fee;

        // Store order in session
        $order_id = 'ORD-' . date('Y') . '-' . rand(100, 999);
        $userOrders = session('user_orders', []);
        $nextId = count($userOrders) + 1;

        $newOrder = [
            'id' => $nextId,
            'order_id' => $order_id,
            'egg_size' => ucwords(str_replace('_', ' ', $egg_size)),
            'product' => $catalog[$egg_size]['name'] ?? ucfirst($egg_size),
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
            'status' => 'Processing',
        ];


        session(['current_order' => $newOrder]);

        $userOrders = session('user_orders', []);
        $userOrders[] = $newOrder;
        session(['user_orders' => $userOrders]);

        return redirect()->route('order-confirmation')->with('success', "Got it! We've sent your order to the farm. We'll let you know when the eggs are on the move.");
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

        $orders = array_map(function ($order) {
            $order['delivery_date'] = $order['delivery_date'] ?? date('Y-m-d');
            $order['status'] = $order['status'] ?? 'Processing';
            return $order;
        }, session('user_orders', []));

        return view('pages.my_orders', ['orders' => $orders]);
    }

    public function orderDetails($id)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to view order details.');
        }

        // Mock order data for demo purposes
        $orders = [
            1 => [
                'order_id' => '#ORD-2026-001',
                'product' => 'Medium (15 Trays)',
                'quantity' => 15,
                'unit_price' => 240,
                'subtotal' => 3600,
                'delivery_fee' => 50,
                'total' => 3650,
                'status' => 'In Transit',
                'expected_delivery' => 'Mar 26',
                'order_date' => 'Mar 15, 2026',
                'address' => '123 Main St',
                'city' => 'Nairobi',
            ],
            3 => [
                'order_id' => '#ORD-2026-003',
                'product' => 'Large (25 Trays)',
                'quantity' => 25,
                'unit_price' => 250,
                'subtotal' => 6250,
                'delivery_fee' => 50,
                'total' => 6300,
                'status' => 'Processing',
                'expected_delivery' => 'Mar 28',
                'order_date' => 'Mar 20, 2026',
                'address' => '456 Oak Ave',
                'city' => 'Nairobi',
            ],
        ];

        // Try session-stored orders first (new behavior)
        $sessionOrders = session('user_orders', []);
        $order = null;

        foreach ($sessionOrders as $sessionOrder) {
            if (isset($sessionOrder['id']) && $sessionOrder['id'] == $id) {
                $order = $sessionOrder;

                // Normalize session orders to match the order details view shape.
                $order['expected_delivery'] = $sessionOrder['expected_delivery']
                    ?? (
                        !empty($sessionOrder['delivery_date'])
                            ? date('M d, Y', strtotime($sessionOrder['delivery_date']))
                            : 'N/A'
                    );

                $order['product'] = $sessionOrder['product']
                    ?? ($sessionOrder['egg_size'] ?? 'N/A');

                $order['order_date'] = !empty($sessionOrder['order_date'])
                    ? date('M d, Y', strtotime($sessionOrder['order_date']))
                    : 'N/A';
                break;
            }
        }

        // Fallback to built-in mock orders
        if (!$order) {
            $order = $orders[$id] ?? null;
        }

        if (!$order) {
            return redirect()->route('my-orders')->with('error', 'Order not found.');
        }

        return view('pages.order_details', ['order' => $order]);
    }

    public function orderHistory()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to view your order history.');
        }

        return view('pages.order_history', [
            'orders' => $this->buildHistoryOrders(),
        ]);
    }

    public function profile()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login')->with('error', 'Please login to view your profile.');
        }

        $role = session('user_role');

        if ($role === 'supplier') {
            return redirect()->route('supplier-profile');
        } elseif ($role === 'distributor') {
            return redirect()->route('distributor-profile');
        }

        // Default buyer profile
        return view('pages.profile', ['role' => 'buyer']);
    }
}
