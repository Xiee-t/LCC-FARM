<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\EggProduct;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $inventory = $this->inventoryItems();
        $recentOrders = $this->supplierOrders();
        $alerts = array_values(array_filter(
            $inventory,
            fn($item) => in_array($item['status'], ['Low Stock', 'Out of Stock'], true)
        ));

        return view('pages.supplier_dashboard', compact('inventory', 'recentOrders', 'alerts'));
    }

    public function inventory()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('pages.inventory_management', [
            'inventory' => $this->inventoryItems(),
        ]);
    }

    public function updateInventory(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $product = EggProduct::findOrFail($id);
        $product->update([
            'stock_quantity' => $validated['quantity'],
        ]);

        return back()->with('success', 'Inventory updated for ' . $this->productName($product) . '.');
    }

    public function orders()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('pages.order_management', [
            'orders' => $this->supplierOrders(),
        ]);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $order = $this->supplierOrderQuery()->findOrFail($id);
        $order->update([
            'order_status' => $validated['status'],
        ]);

        return back()->with('success', 'Order #' . $order->order_number . ' marked as ' . $validated['status'] . '.');
    }

    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $business = $user->business;

        $totalProducts = EggProduct::count();
        $completedOrders = $business ? Order::where('supplier_id', $business->id)->where('order_status', 'Completed')->count() : 0;

        return view('pages.supplier_profile', [
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
                'total_products' => $totalProducts,
                'completed_orders' => $completedOrders,
            ],
        ]);
    }

    private function inventoryItems(): array
    {
        return EggProduct::query()
            ->orderBy('id')
            ->get()
            ->map(function (EggProduct $product) {
                $threshold = (int) ($product->low_stock_threshold ?? 0);
                $stock = (int) $product->stock_quantity;

                return [
                    'id' => $product->id,
                    'product' => $this->productName($product),
                    'stock' => $stock,
                    'current_stock' => $stock,
                    'min_threshold' => $threshold,
                    'unit_price' => (float) $product->price_per_unit,
                    'status' => $stock === 0 ? 'Out of Stock' : ($stock <= $threshold ? 'Low Stock' : 'Good'),
                ];
            })
            ->all();
    }

    private function supplierOrders(): array
    {
        return $this->supplierOrderQuery()
            ->with(['user', 'items.product', 'delivery'])
            ->latest('created_at')
            ->get()
            ->map(function (Order $order) {
                $item = $order->items->first();

                return [
                    'id' => $order->id,
                    'order_id' => $order->order_number,
                    'product' => $item?->product ? $this->productName($item->product) : 'Unknown Product',
                    'quantity' => (int) ($item?->quantity ?? 0),
                    'customer' => $order->user?->name ?? 'Guest Customer',
                    'status' => $order->order_status,
                    'order_date' => optional($order->created_at)->format('F d, Y'),
                    'expected_delivery' => optional($order->created_at)->addDays(2)?->format('F d, Y'),
                ];
            })
            ->all();
    }

    private function supplierOrderQuery()
    {
        $businessId = optional($this->currentSupplierBusiness())->id;

        return Order::query()->where('supplier_id', $businessId);
    }

    private function currentSupplierBusiness(): ?Business
    {
        return Auth::user()?->business;
    }

    private function productName(EggProduct $product): string
    {
        return $product->category === 'Tray'
            ? 'Jumbo Eggs'
            : $product->category . ' Eggs';
    }
}
