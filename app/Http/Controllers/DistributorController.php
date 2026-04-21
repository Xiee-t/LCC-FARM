<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function dashboard()
    {
        $orders = $this->distributorOrders();
        $suppliers = $this->suppliers();

        // 1. Data for the metrics cards
        $stats = [
            'pending_orders' => count(array_filter($orders, fn ($order) => $order['status'] === 'Pending')),
            'total_orders_month' => count($orders),
            'total_revenue' => 0.00,
            'active_suppliers' => count(array_filter($suppliers, fn ($supplier) => $supplier['status'] === 'Active')),
        ];

        // 2. Data for recent orders table
        $recentOrders = array_map(function ($order) {
            return [
                'order_id' => $order['order_id'],
                'supplier' => $order['supplier'],
                'product' => $order['product'],
                'quantity' => $order['quantity'],
                'expected_delivery' => $order['delivery'],
                'status' => $order['status'],
            ];
        }, $orders);

        // 4. Pass all variables to the view using compact
        return view('pages.distributor_dashboard', compact('stats', 'recentOrders', 'suppliers'));
    }

    public function availableOrders()
    {
        $orders = $this->distributorOrders();
        return view('pages.distributor_available_orders', compact('orders'));
    }

    public function acceptOrder($id)
    {
        // Logic to claim an order for delivery
        return back()->with('success', 'Order accepted for delivery.');
    }

    public function trackOrders()
    {
        $trackedOrders = array_map(function ($order) {
            return [
                'id' => $order['id'],
                'order_id' => $order['order_id'],
                'supplier' => $order['supplier'],
                'product' => $order['product'],
                'status' => $order['status'],
                'eta' => $order['eta'],
            ];
        }, $this->distributorOrders());

        return view('pages.distributor_track_orders', compact('trackedOrders'));
    }

    public function manageSuppliers()
    {
        $suppliers = $this->suppliers();
        return view('pages.distributor_manage_suppliers', compact('suppliers'));
    }

    public function deliveryTracking($id)
    {
        $order = collect($this->distributorOrders())->firstWhere('id', (int) $id);

        if (! $order) {
            abort(404);
        }

        return view('pages.distributor_delivery_tracking', compact('order'));
    }

    public function profile()
    {
        return view('pages.profile');
    }

    private function distributorOrders(): array
    {
        return [
            [
                'id' => 1,
                'order_id' => 'ORD-1001',
                'supplier' => 'LCC Farm 1',
                'product' => 'Large Eggs',
                'quantity' => 10,
                'delivery' => '2026-04-25',
                'eta' => 'April 25, 2026',
                'status' => 'Pending',
                'route' => 'LCC Farm 1 -> City Hub -> Main Store',
                'current_status' => 'Preparing',
            ],
            [
                'id' => 2,
                'order_id' => 'ORD-1002',
                'supplier' => 'Farm 2',
                'product' => 'Medium Eggs',
                'quantity' => 8,
                'delivery' => '2026-04-23',
                'eta' => 'April 23, 2026',
                'status' => 'In Transit',
                'route' => 'Farm 2 -> North Warehouse -> Main Store',
                'current_status' => 'On the Way',
            ],
            [
                'id' => 3,
                'order_id' => 'ORD-1003',
                'supplier' => 'Green Valley Farm',
                'product' => 'Jumbo Eggs',
                'quantity' => 12,
                'delivery' => '2026-04-20',
                'eta' => 'April 20, 2026',
                'status' => 'Delivered',
                'route' => 'Green Valley Farm -> Main Store',
                'current_status' => 'Delivered',
            ],
        ];
    }

    private function suppliers(): array
    {
        return [
            [
                'name' => 'LCC Farm 1',
                'status' => 'Active',
                'rating' => 4.8,
                'products' => 15,
            ],
            [
                'name' => 'Farm 2',
                'status' => 'Active',
                'rating' => 4.5,
                'products' => 10,
            ],
            [
                'name' => 'Green Valley Farm',
                'status' => 'Active',
                'rating' => 4.7,
                'products' => 11,
            ],
        ];
    }
}
