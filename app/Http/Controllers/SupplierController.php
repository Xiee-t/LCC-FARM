<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class SupplierController extends Controller
{
    public function dashboard()
    {
        $alerts = []; // Low stock alerts (implement later)
        $inventory = Product::all(); // All products for stats
$recentOrders = Order::where('supplier', 'like', '%Farm%')->latest()->take(10)->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'order_id' => $order->order_id,
                'supplier' => $order->supplier,
                'product' => $order->product,
                'quantity' => $order->quantity,
                'status' => $order->status,
                'expected_delivery' => $order->expected_delivery,
                'customer' => 'Distributor ' . substr($order->supplier, 0, 3),
            ];
        })->toArray();
        return view('pages.supplier_dashboard', compact('alerts', 'inventory', 'recentOrders'));
    }

    public function inventory()
    {
        $products = Product::all();
        return view('pages.supplier_inventory', compact('products'));
    }

    public function updateInventory(Request $request, $id)
    {
        // Logic to update stock levels
        return back()->with('success', 'Inventory updated.');
    }

    public function orders()
    {
        $orders = Order::latest()->take(10)->get();
        return view('pages.supplier_orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        // Logic to change order status (e.g., 'Shipped')
        return back()->with('success', 'Status updated.');
    }

    public function profile()
    {
        return view('pages.supplier_profile');
    }
}
