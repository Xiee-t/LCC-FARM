<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function dashboard()
    {
        if (!session('user_logged_in') || session('user_role') !== 'distributor') {
            return redirect()->route('login')->with('error', 'Please login as a distributor.');
        }

        // Mock data for distributor dashboard
        $stats = [
            'pending_orders' => 12,
            'total_orders_month' => 45,
            'total_revenue' => 156000,
            'active_suppliers' => 8,
        ];

        $recentOrders = [
            [
                'id' => 1,
                'order_id' => '#ORD-2026-001',
                'supplier' => 'Farm A Suppliers',
                'product' => 'Medium Eggs',
                'quantity' => 50,
                'order_date' => 'Mar 20, 2026',
                'expected_delivery' => 'Mar 22, 2026',
                'status' => 'Pending',
            ],
            [
                'id' => 2,
                'order_id' => '#ORD-2026-002',
                'supplier' => 'Green Farm Ltd',
                'product' => 'Large Eggs',
                'quantity' => 75,
                'order_date' => 'Mar 19, 2026',
                'expected_delivery' => 'Mar 21, 2026',
                'status' => 'Delivered',
            ],
            [
                'id' => 3,
                'order_id' => '#ORD-2026-003',
                'supplier' => 'Premium Eggs Co',
                'product' => 'Small Eggs',
                'quantity' => 30,
                'order_date' => 'Mar 21, 2026',
                'expected_delivery' => 'Mar 23, 2026',
                'status' => 'In Transit',
            ],
        ];

        $suppliers = [
            ['name' => 'Farm A Suppliers', 'rating' => 4.8, 'products' => 'All Sizes', 'status' => 'Active'],
            ['name' => 'Green Farm Ltd', 'rating' => 4.5, 'products' => 'Medium, Large', 'status' => 'Active'],
            ['name' => 'Premium Eggs Co', 'rating' => 4.9, 'products' => 'All Sizes', 'status' => 'Active'],
        ];

        return view('pages.distributor_dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'suppliers' => $suppliers,
        ]);
    }

    public function profile()
    {
        if (!session('user_logged_in') || session('user_role') !== 'distributor') {
            return redirect()->route('login')->with('error', 'Please login as a distributor.');
        }

        return view('pages.profile', ['role' => 'distributor']);
    }

    public function availableOrders()
    {
        if (!session('user_logged_in') || session('user_role') !== 'distributor') {
            return redirect()->route('login')->with('error', 'Please login as a distributor.');
        }

        $orders = [
            ['id' => 101, 'order_id' => '#ORD-2026-010', 'product' => 'Large Eggs', 'quantity' => 80, 'supplier' => 'Farm A Suppliers', 'delivery' => 'Mar 31, 2026', 'status' => 'Pending'],
            ['id' => 102, 'order_id' => '#ORD-2026-011', 'product' => 'XL Eggs', 'quantity' => 40, 'supplier' => 'Green Farm Ltd', 'delivery' => 'Apr 01, 2026', 'status' => 'Pending'],
            ['id' => 103, 'order_id' => '#ORD-2026-012', 'product' => 'Medium Eggs', 'quantity' => 100, 'supplier' => 'Premium Eggs Co', 'delivery' => 'Apr 02, 2026', 'status' => 'Pending'],
        ];

        return view('pages.distributor_available_orders', ['orders' => $orders]);
    }

    public function acceptOrder(Request $request, $id)
    {
        if (!session('user_logged_in') || session('user_role') !== 'distributor') {
            return redirect()->route('login')->with('error', 'Please login as a distributor.');
        }

        // In real app, update DB order status; demo: flash message.
        return redirect()->route('distributor-available-orders')->with('success', "Order #{$id} accepted successfully.");
    }

    public function trackOrders()
    {
        if (!session('user_logged_in') || session('user_role') !== 'distributor') {
            return redirect()->route('login')->with('error', 'Please login as a distributor.');
        }

        $trackedOrders = [
            ['id' => 1, 'order_id' => '#ORD-2026-001', 'supplier' => 'Farm A Suppliers', 'product' => 'Medium Eggs', 'status' => 'In Transit', 'eta' => 'Apr 02, 2026'],
            ['id' => 2, 'order_id' => '#ORD-2026-002', 'supplier' => 'Green Farm Ltd', 'product' => 'Large Eggs', 'status' => 'Delivered', 'eta' => 'Mar 21, 2026'],
            ['id' => 3, 'order_id' => '#ORD-2026-003', 'supplier' => 'Premium Eggs Co', 'product' => 'Small Eggs', 'status' => 'Preparing', 'eta' => 'Apr 04, 2026'],
        ];

        return view('pages.distributor_track_orders', ['trackedOrders' => $trackedOrders]);
    }

    public function manageSuppliers()
    {
        if (!session('user_logged_in') || session('user_role') !== 'distributor') {
            return redirect()->route('login')->with('error', 'Please login as a distributor.');
        }

        $suppliers = [
            ['name' => 'Farm A Suppliers', 'rating' => 4.8, 'products' => 'All Sizes', 'status' => 'Active'],
            ['name' => 'Green Farm Ltd', 'rating' => 4.5, 'products' => 'Medium, Large', 'status' => 'Active'],
            ['name' => 'Premium Eggs Co', 'rating' => 4.9, 'products' => 'All Sizes', 'status' => 'Active'],
        ];

        return view('pages.distributor_manage_suppliers', ['suppliers' => $suppliers]);
    }

    public function deliveryTracking($id)
    {
        if (!session('user_logged_in') || session('user_role') !== 'distributor') {
            return redirect()->route('login')->with('error', 'Please login as a distributor.');
        }

        $order = [
            'id' => $id,
            'order_id' => '#ORD-2026-0'.$id,
            'supplier' => 'Farm A Suppliers',
            'product' => 'Medium Eggs',
            'quantity' => 120,
            'current_status' => 'Preparing',
            'route' => 'Nairobi → Kiambu → Nakuru',
            'eta' => 'Apr 2, 2026',
        ];

        return view('pages.distributor_delivery_tracking', ['order' => $order]);
    }
}

