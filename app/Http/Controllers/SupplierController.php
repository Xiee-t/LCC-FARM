<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function dashboard()
    {
        if (!session('user_logged_in') || session('user_role') !== 'supplier') {
            return redirect()->route('login')->with('error', 'Please login as a supplier.');
        }

        // Mock inventory data
        $inventory = [
            ['id' => 1, 'product' => 'Small Eggs', 'stock' => 150, 'threshold' => 100, 'status' => 'Good'],
            ['id' => 2, 'product' => 'Medium Eggs', 'stock' => 45, 'threshold' => 100, 'status' => 'Low Stock'],
            ['id' => 3, 'product' => 'Large Eggs', 'stock' => 0, 'threshold' => 100, 'status' => 'Out of Stock'],
            ['id' => 4, 'product' => 'XL Eggs', 'stock' => 200, 'threshold' => 150, 'status' => 'Good'],
        ];

        // Get low/out of stock items
        $alerts = array_filter($inventory, function($item) {
            return $item['status'] !== 'Good';
        });

        // Mock recent orders
        $recentOrders = [
            ['id' => 1, 'order_id' => '#ORD-2026-001', 'product' => 'Medium Eggs', 'quantity' => 15, 'status' => 'In Progress', 'customer' => 'John Doe'],
            ['id' => 2, 'order_id' => '#ORD-2026-002', 'product' => 'Large Eggs', 'quantity' => 25, 'status' => 'Pending', 'customer' => 'Jane Smith'],
            ['id' => 3, 'order_id' => '#ORD-2026-003', 'product' => 'Small Eggs', 'quantity' => 10, 'status' => 'Completed', 'customer' => 'Bob Johnson'],
        ];

        return view('pages.supplier_dashboard', [
            'inventory' => $inventory,
            'alerts' => $alerts,
            'recentOrders' => $recentOrders,
        ]);
    }

    public function inventory()
    {
        if (!session('user_logged_in') || session('user_role') !== 'supplier') {
            return redirect()->route('login')->with('error', 'Please login as a supplier.');
        }

        // Mock full inventory data
        $inventory = [
            ['id' => 1, 'product' => 'Small Eggs (Trays)', 'current_stock' => 150, 'min_threshold' => 100, 'unit_price' => 230, 'status' => 'Good'],
            ['id' => 2, 'product' => 'Medium Eggs (Trays)', 'current_stock' => 45, 'min_threshold' => 100, 'unit_price' => 240, 'status' => 'Low Stock'],
            ['id' => 3, 'product' => 'Large Eggs (Trays)', 'current_stock' => 0, 'min_threshold' => 100, 'unit_price' => 250, 'status' => 'Out of Stock'],
            ['id' => 4, 'product' => 'XL Eggs (Trays)', 'current_stock' => 200, 'min_threshold' => 150, 'unit_price' => 260, 'status' => 'Good'],
            ['id' => 5, 'product' => 'Jumbo Eggs (Trays)', 'current_stock' => 75, 'min_threshold' => 100, 'unit_price' => 280, 'status' => 'Low Stock'],
        ];

        return view('pages.inventory_management', ['inventory' => $inventory]);
    }

    public function updateInventory(Request $request, $id)
    {
        if (!session('user_logged_in') || session('user_role') !== 'supplier') {
            return redirect()->route('login')->with('error', 'Please login as a supplier.');
        }

        $request->validate([
            'quantity' => 'required|numeric|min:0',
        ]);

        // In a real application, this would update the database
        // For now, we'll redirect back with a success message
        return redirect()->route('supplier-inventory')->with('success', 'Inventory updated successfully!');
    }

    public function orders()
    {
        if (!session('user_logged_in') || session('user_role') !== 'supplier') {
            return redirect()->route('login')->with('error', 'Please login as a supplier.');
        }

        // Mock incoming orders data
        $orders = [
            [
                'id' => 1,
                'order_id' => '#ORD-2026-001',
                'product' => 'Medium Eggs',
                'quantity' => 15,
                'status' => 'Pending',
                'customer' => 'John Doe',
                'order_date' => 'Mar 20, 2026',
                'expected_delivery' => 'Mar 26, 2026',
            ],
            [
                'id' => 2,
                'order_id' => '#ORD-2026-002',
                'product' => 'Large Eggs',
                'quantity' => 25,
                'status' => 'In Progress',
                'customer' => 'Jane Smith',
                'order_date' => 'Mar 21, 2026',
                'expected_delivery' => 'Mar 28, 2026',
            ],
            [
                'id' => 3,
                'order_id' => '#ORD-2026-003',
                'product' => 'Small Eggs',
                'quantity' => 10,
                'status' => 'Completed',
                'customer' => 'Bob Johnson',
                'order_date' => 'Mar 15, 2026',
                'expected_delivery' => 'Mar 22, 2026',
            ],
        ];

        return view('pages.order_management', ['orders' => $orders]);
    }

    public function profile()
    {
        if (!session('user_logged_in') || session('user_role') !== 'supplier') {
            return redirect()->route('login')->with('error', 'Please login as a supplier.');
        }

        return view('pages.profile', ['role' => 'supplier']);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        if (!session('user_logged_in') || session('user_role') !== 'supplier') {
            return redirect()->route('login')->with('error', 'Please login as a supplier.');
        }

        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        // In a real application, this would update the database
        // For now, we'll redirect back with a success message
        return redirect()->route('supplier-orders')->with('success', 'Order status updated successfully!');
    }
}
