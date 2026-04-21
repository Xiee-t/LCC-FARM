<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function dashboard()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $inventory = $this->inventoryItems();
        $recentOrders = $this->supplierOrders();
        $alerts = array_values(array_filter(
            $inventory,
            fn ($item) => in_array($item['status'], ['Low Stock', 'Out of Stock'], true)
        ));

        return view('pages.supplier_dashboard', compact('inventory', 'recentOrders', 'alerts'));
    }

    public function inventory()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        return view('pages.inventory_management', [
            'inventory' => $this->inventoryItems(),
        ]);
    }

    public function updateInventory(Request $request, $id)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        return back()->with('success', 'Inventory updated for item #' . $id . '.');
    }

    public function orders()
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        return view('pages.order_management', [
            'orders' => $this->supplierOrders(),
        ]);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        if (!session('user_logged_in')) {
            return redirect()->route('login');
        }

        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        return back()->with('success', 'Order #' . $id . ' marked as ' . $request->status . '.');
    }

    private function inventoryItems(): array
    {
        return [
            [
                'id' => 1,
                'product' => 'Small Eggs',
                'stock' => 180,
                'current_stock' => 180,
                'min_threshold' => 100,
                'unit_price' => 180,
                'status' => 'Good',
            ],
            [
                'id' => 2,
                'product' => 'Medium Eggs',
                'stock' => 85,
                'current_stock' => 85,
                'min_threshold' => 100,
                'unit_price' => 210,
                'status' => 'Low Stock',
            ],
            [
                'id' => 3,
                'product' => 'Large Eggs',
                'stock' => 0,
                'current_stock' => 0,
                'min_threshold' => 80,
                'unit_price' => 240,
                'status' => 'Out of Stock',
            ],
        ];
    }

    private function supplierOrders(): array
    {
        return [
            [
                'id' => 1,
                'order_id' => 'ORD-1001',
                'product' => 'Medium Eggs',
                'quantity' => 30,
                'customer' => 'Maria Santos',
                'status' => 'Pending',
                'order_date' => 'April 19, 2026',
                'expected_delivery' => 'April 23, 2026',
            ],
            [
                'id' => 2,
                'order_id' => 'ORD-1002',
                'product' => 'Large Eggs',
                'quantity' => 18,
                'customer' => 'Ramon Cruz',
                'status' => 'In Progress',
                'order_date' => 'April 18, 2026',
                'expected_delivery' => 'April 22, 2026',
            ],
            [
                'id' => 3,
                'order_id' => 'ORD-1003',
                'product' => 'Small Eggs',
                'quantity' => 25,
                'customer' => 'Liza Flores',
                'status' => 'Completed',
                'order_date' => 'April 16, 2026',
                'expected_delivery' => 'April 20, 2026',
            ],
        ];
    }
}
