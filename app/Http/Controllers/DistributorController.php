<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function dashboard()
    {
        // 1. Data for the metrics cards
        $stats = [
            'pending_orders' => 0,
            'total_orders_month' => 0,
            'total_revenue' => 0.00,
            'active_suppliers' => 0,
        ];

        // 2. Data for recent orders table
        $recentOrders = [
            [
                'order_id' => 'ORD-1001',
                'supplier' => 'LCC Farm 1',
                'product' => 'Large Eggs',
                'quantity' => 10,
                'expected_delivery' => '2026-04-25',
                'status' => 'Pending'
            ],
        ];

        // 3. Data for active suppliers (Includes rating and products to prevent errors)
        $suppliers = [
            [
                'name' => 'LCC Farm 1', 
                'status' => 'Active', 
                'rating' => 4.8, 
                'products' => 15
            ],
            [
                'name' => 'Farm 2', 
                'status' => 'Active', 
                'rating' => 4.5, 
                'products' => 10
            ],
        ];

        // 4. Pass all variables to the view using compact
        return view('pages.distributor_dashboard', compact('stats', 'recentOrders', 'suppliers'));
    }

    public function availableOrders()
    {
        return view('pages.distributor_available_orders');
    }

    public function acceptOrder($id)
    {
        // Logic to claim an order for delivery
        return back()->with('success', 'Order accepted for delivery.');
    }

    public function trackOrders()
    {
        return view('pages.distributor_track_orders');
    }

    public function manageSuppliers()
    {
        return view('pages.distributor_manage_suppliers');
    }

    public function profile()
    {
        return view('pages.distributor_profile');
    }
}