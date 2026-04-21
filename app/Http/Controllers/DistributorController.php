<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Supplier;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DistributorController extends Controller
{
    public function dashboard()
    {
        // Metrics
        $stats = [
            'pending_orders' => Order::pending()->count(),
            'total_orders_month' => Order::thisMonth()->count(),
            'total_revenue' => Order::thisMonth()->sum('total_price') ?? 0,
            'active_suppliers' => Supplier::where('status', 'Active')->count(),
        ];

        // Recent orders
        $recentOrders = Order::recent()->get()->map(function ($order) {
            return [
                'order_id' => $order->order_id,
                'supplier' => $order->supplier,
                'product' => $order->product,
                'quantity' => $order->quantity,
                'expected_delivery' => $order->expected_delivery,
                'status' => $order->status,
            ];
        })->toArray();

        // Suppliers
        $suppliers = Supplier::all()->map(function ($supplier) {
            return [
                'name' => $supplier->name,
                'status' => $supplier->status,
                'rating' => $supplier->rating,
                'products' => $supplier->products,
            ];
        })->toArray();

        return view('pages.distributor_dashboard', compact('stats', 'recentOrders', 'suppliers'));
    }

    public function availableOrders()
    {
        $orders = Order::pending()->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'order_id' => $order->order_id,
                'product' => $order->product,
                'quantity' => $order->quantity,
                'supplier' => $order->supplier,
                'delivery' => $order->expected_delivery,
            ];
        })->toArray();

        return view('pages.distributor_available_orders', compact('orders'));
    }

    public function acceptOrder($id)
    {
        $order = Order::findOrFail($id);

        if (Auth::check()) {
            $userId = Auth::id();
            if ($order->distributor_id && $order->distributor_id != $userId) {
                return back()->with('error', 'Unauthorized: This order belongs to another distributor.');
            }
            $order->update([
                'status' => 'Accepted',
                'distributor_id' => $userId,
            ]);
        } else {
            return back()->with('error', 'Please login as distributor to accept orders.');
        }

        return back()->with('success', 'Order accepted for delivery.');
    }

    /**
     * Update order status from tracking page.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'step' => 'required|in:Preparing,On the Way,Delivered',
        ]);

        $order = Order::findOrFail($id);

        if (Auth::check()) {
            $userId = Auth::id();
            if ($order->distributor_id && $order->distributor_id != $userId) {
                return back()->with('error', 'Unauthorized: This order belongs to another distributor.');
            }

            $statusMap = [
                'Preparing' => 'Accepted',
                'On the Way' => 'In Transit',
                'Delivered' => 'Delivered',
            ];

            $status = $statusMap[$request->step] ?? $order->status;

            $order->update([
                'status' => $status,
                'distributor_id' => $userId,
            ]);

            return back()->with('success', "Order status updated to {$request->step}.");
        }

        return back()->with('error', 'Please login as distributor to update status.');
    }

    public function trackOrders()
    {
        $trackedOrders = Order::all()->map(function ($order) {
            return [
                'id' => $order->id,
                'order_id' => $order->order_id,
                'supplier' => $order->supplier,
                'product' => $order->product,
                'status' => $order->status,
                'eta' => $order->expected_delivery,
            ];
        })->toArray();

        return view('pages.distributor_track_orders', compact('trackedOrders'));
    }

    public function manageSuppliers()
    {
        $suppliers = Supplier::all()->map(function ($supplier) {
            return [
                'name' => $supplier->name,
                'status' => $supplier->status,
                'rating' => $supplier->rating,
                'products' => $supplier->products,
            ];
        })->toArray();

        return view('pages.distributor_manage_suppliers', compact('suppliers'));
    }

    public function deliveryTracking($id)
    {
        $orderModel = Order::findOrFail($id);
        $order = [
            'id' => $orderModel->id,
            'order_id' => $orderModel->order_id,
            'supplier' => $orderModel->supplier,
            'product' => $orderModel->product,
            'quantity' => $orderModel->quantity,
            'eta' => $orderModel->expected_delivery,
            'route' => match($orderModel->supplier) {
                'LCC Farms' => 'LCC Farms -> City Hub -> Main Store',
                'Green Valley Farm' => 'Green Valley Farm -> Main Store',
                'Sunny Ridge Poultry' => 'Sunny Ridge Poultry -> North Warehouse -> Main Store',
                default => 'Supplier -> Distribution Hub -> Main Store',
            },
            'current_status' => match($orderModel->status) {
                'Pending' => 'Preparing',
                'In Transit' => 'On the Way',
                'Accepted', 'Delivered' => 'Delivered',
                default => $orderModel->status,
            },
        ];

        return view('pages.distributor_delivery_tracking', compact('order'));
    }

    public function profile()
    {
        return view('pages.profile');
    }
}




