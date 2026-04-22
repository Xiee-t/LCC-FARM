<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Delivery;
use App\Models\EggProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    private const DELIVERY_FEE = 50;

    public function dashboard()
    {
        $user = Auth::user();
        if ($user) {
            $routeName = $this->dashboardRouteForRole($user->role);
            if (Route::has($routeName)) {
                return redirect()->route($routeName);
            }
        }

        return redirect()->route('landing');
    }

    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $business = $user->business;

        return view('pages.profile', [
            'profile' => [
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?: 'Not provided',
                'role' => $user->role,
                'member_since' => optional($user->created_at)->format('F d, Y') ?? 'Unknown',
                'status' => 'Active & Verified',
                'business_name' => $business?->business_name,
                'business_address' => $business?->address,
                'contact_person' => $business?->contact_person,
            ],
        ]);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName() ?: 'Social User',
                    'password' => Hash::make(str()->random(32)),
                    'role' => 'customer',
                ]
            );

            Auth::login($user);
            request()->session()->regenerate();

            return redirect()->route($this->dashboardRouteForRole($user->role));
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

        $credentials = filter_var($loginField, FILTER_VALIDATE_EMAIL)
            ? ['email' => $loginField, 'password' => $password]
            : ['phone' => $loginField, 'password' => $password];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            session([
                'user_logged_in' => true,
                'user_role' => $user->role,
                'user_identity' => $user->email,
                'user_name' => $user->name,
            ]);

            return redirect()->route($this->dashboardRouteForRole($user->role))->with('success', 'Login successful!');
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
            'role' => ['required', 'in:buyer,customer,supplier,distributor'],
        ]);

        $role = $validated['role'] === 'buyer' ? 'customer' : $validated['role'];

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);

        if (in_array($role, ['supplier', 'distributor'], true)) {
            Business::create([
                'user_id' => $user->id,
                'business_name' => $validated['name'] . ' ' . ucfirst($role) . ' Business',
                'address' => 'Address pending profile update',
                'contact_person' => $validated['name'],
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        session([
            'user_logged_in' => true,
            'user_role' => $role,
            'user_identity' => $user->email,
            'user_name' => $user->name,
        ]);

        return redirect()->route($this->dashboardRouteForRole($role))->with('success', 'Registration successful!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget([
            'user_logged_in',
            'user_role',
            'user_identity',
            'user_name',
        ]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }

    public function buyerDashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $products = $this->buyerProducts();
        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->with('delivery')
            ->get();

        $activeOrderCount = $orders->filter(function (Order $order) {
            return optional($order->delivery)->delivery_status !== 'Delivered';
        })->count();

        $identity = Auth::user()->email;
        $totalStock = array_sum(array_column($products, 'stock'));

        return view('pages.buyer_dashboard', compact('products', 'identity', 'totalStock', 'activeOrderCount'));
    }

    public function placeOrder()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $products = $this->buyerProducts();
        $prefill = [
            'egg_size' => request('size'),
        ];

        return view('pages.place_order', compact('products', 'prefill'));
    }

    public function myOrders()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->with(['items.product', 'delivery'])
            ->latest('created_at')
            ->get()
            ->filter(fn (Order $order) => optional($order->delivery)->delivery_status !== 'Delivered')
            ->map(fn (Order $order) => $this->formatBuyerOrderSummary($order))
            ->all();

        return view('pages.my_orders', ['orders' => $orders]);
    }

    public function orderHistory()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->with(['items.product', 'delivery'])
            ->latest('created_at')
            ->get()
            ->filter(fn (Order $order) => optional($order->delivery)->delivery_status === 'Delivered')
            ->map(fn (Order $order) => $this->formatBuyerOrderHistory($order))
            ->all();

        return view('pages.order_history', ['orders' => $orders]);
    }

    public function orderDetails($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::query()
            ->where('user_id', Auth::id())
            ->with(['items.product', 'delivery'])
            ->findOrFail($id);

        return view('pages.order_details', [
            'order' => $this->formatBuyerOrderDetails($order),
        ]);
    }

    public function storeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'egg_size' => 'required|exists:egg_products,id',
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'delivery_date' => 'required|date|after:tomorrow',
        ]);

        $product = EggProduct::findOrFail($validated['egg_size']);
        $supplier = $this->resolveSupplierBusiness($product);

        $order = DB::transaction(function () use ($validated, $product, $supplier) {
            $subtotal = $product->price_per_unit * $validated['quantity'];
            $total = $subtotal + self::DELIVERY_FEE;

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_type' => 'registered',
                'order_number' => $this->nextOrderNumber(),
                'order_status' => 'Pending',
                'supplier_id' => optional($supplier)->id,
                'total_amount' => $total,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => (int) $validated['quantity'],
                'unit_price' => $product->price_per_unit,
            ]);

            Delivery::create([
                'order_id' => $order->id,
                'distributor_id' => null,
                'delivery_status' => 'Preparing',
                'delivery_address' => $validated['address'] . ', ' . $validated['city'] . ' ' . $validated['postal_code'],
                'suggested_sequence' => null,
                'actual_delivery_time' => null,
            ]);

            $product->decrement('stock_quantity', (int) $validated['quantity']);

            return $order;
        });

        return redirect()->route('order-details', $order->id)->with('success', 'Order placed successfully!');
    }

    private function buyerProducts(): array
    {
        return EggProduct::query()
            ->orderBy('id')
            ->get()
            ->map(function (EggProduct $product) {
                return [
                    'id' => $product->id,
                    'size' => $product->category === 'Tray' ? 'Jumbo' : $product->category,
                    'name' => $this->productDisplayName($product),
                    'stock' => (int) $product->stock_quantity,
                    'price' => (float) $product->price_per_unit,
                ];
            })
            ->all();
    }

    private function formatBuyerOrderSummary(Order $order): array
    {
        $item = $order->items->first();
        $product = $item?->product;

        return [
            'id' => $order->id,
            'order_id' => $order->order_number,
            'egg_size' => $product ? $this->productDisplayName($product) : 'Unknown Product',
            'quantity' => (int) ($item?->quantity ?? 0),
            'delivery_date' => optional($order->created_at)->addDays(2)?->toDateString(),
            'status' => $this->buyerStatus(optional($order->delivery)->delivery_status),
        ];
    }

    private function formatBuyerOrderDetails(Order $order): array
    {
        $item = $order->items->first();
        $product = $item?->product;
        $address = $this->splitDeliveryAddress($order->delivery?->delivery_address);
        $subtotal = (float) (($item?->quantity ?? 0) * ($item?->unit_price ?? 0));

        return [
            'order_id' => $order->order_number,
            'order_date' => optional($order->created_at)->format('M d, Y'),
            'expected_delivery' => optional($order->created_at)->addDays(2)?->format('M d, Y'),
            'status' => $this->buyerStatus(optional($order->delivery)->delivery_status),
            'product' => $product ? $this->productDisplayName($product) : 'Unknown Product',
            'unit_price' => (float) ($item?->unit_price ?? 0),
            'quantity' => (int) ($item?->quantity ?? 0),
            'address' => $address['address'],
            'city' => $address['city'],
            'subtotal' => $subtotal,
            'delivery_fee' => self::DELIVERY_FEE,
            'total' => (float) $order->total_amount,
        ];
    }

    private function formatBuyerOrderHistory(Order $order): array
    {
        $item = $order->items->first();
        $product = $item?->product;

        return [
            'id' => $order->id,
            'order_id' => $order->order_number,
            'product' => $product ? $this->productDisplayName($product) : 'Unknown Product',
            'quantity' => (int) ($item?->quantity ?? 0),
            'completed_at' => optional($order->delivery?->actual_delivery_time ?? $order->updated_at)->format('M d, Y'),
            'total' => (float) $order->total_amount,
            'status' => 'Delivered',
            'egg_size_key' => $product?->id,
        ];
    }

    private function buyerStatus(?string $deliveryStatus): string
    {
        return match ($deliveryStatus) {
            'Delivered' => 'Delivered',
            'On the Way' => 'In Transit',
            default => 'Processing',
        };
    }

    private function productDisplayName(EggProduct $product): string
    {
        return $product->category === 'Tray'
            ? 'Jumbo Eggs'
            : $product->category . ' Eggs';
    }

    private function dashboardRouteForRole(?string $role): string
    {
        return match ($role) {
            'supplier' => 'supplier-dashboard',
            'distributor' => 'distributor-dashboard',
            default => 'buyer-dashboard',
        };
    }

    private function resolveSupplierBusiness(EggProduct $product): ?Business
    {
        $suppliers = Business::query()
            ->whereHas('user', fn ($query) => $query->where('role', 'supplier'))
            ->orderBy('id')
            ->get();

        if ($suppliers->isEmpty()) {
            return null;
        }

        return $suppliers[($product->id - 1) % $suppliers->count()];
    }

    private function nextOrderNumber(): string
    {
        $nextId = ((int) Order::max('id')) + 1;

        return 'ORD-' . str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);
    }

    private function splitDeliveryAddress(?string $deliveryAddress): array
    {
        $parts = array_map('trim', explode(',', (string) $deliveryAddress));

        return [
            'address' => $parts[0] ?? '',
            'city' => $parts[1] ?? '',
        ];
    }
}
