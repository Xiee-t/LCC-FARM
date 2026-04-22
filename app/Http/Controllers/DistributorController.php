<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Delivery;
use App\Models\EggProduct;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributorController extends Controller
{
    public function dashboard()
    {
        $recentDeliveries = $this->deliveryQuery()
            ->with(['order.items.product', 'order.supplierBusiness'])
            ->latest('id')
            ->get();

        $stats = [
            'pending_orders' => $recentDeliveries->where('delivery_status', 'Preparing')->count(),
            'total_orders_month' => Order::thisMonth()->count(),
            'total_revenue' => (float) Order::thisMonth()->sum('total_amount'),
            'active_suppliers' => Business::query()->whereHas('user', fn ($query) => $query->where('role', 'supplier'))->count(),
        ];

        $recentOrders = $recentDeliveries->take(10)->map(function (Delivery $delivery) {
            $item = $delivery->order?->items->first();

            return [
                'id' => $delivery->order_id,
                'order_id' => $delivery->order?->order_number,
                'supplier' => $delivery->order?->supplierBusiness?->business_name ?? 'Unassigned Supplier',
                'product' => $item?->product ? $this->productName($item->product) : 'Unknown Product',
                'quantity' => (int) ($item?->quantity ?? 0),
                'expected_delivery' => optional($delivery->order?->created_at)->addDays(2)?->toDateString(),
                'status' => $this->deliveryBadgeStatus($delivery->delivery_status),
            ];
        })->all();

        $suppliers = $this->supplierCards();

        return view('pages.distributor_dashboard', compact('stats', 'recentOrders', 'suppliers'));
    }

    public function availableOrders()
    {
        $orders = Delivery::query()
            ->whereNull('distributor_id')
            ->with(['order.items.product', 'order.supplierBusiness'])
            ->latest('id')
            ->get()
            ->map(function (Delivery $delivery) {
                $item = $delivery->order?->items->first();

                return [
                    'id' => $delivery->order_id,
                    'order_id' => $delivery->order?->order_number,
                    'product' => $item?->product ? $this->productName($item->product) : 'Unknown Product',
                    'quantity' => (int) ($item?->quantity ?? 0),
                    'supplier' => $delivery->order?->supplierBusiness?->business_name ?? 'Unassigned Supplier',
                    'delivery' => optional($delivery->order?->created_at)->addDays(2)?->toDateString(),
                ];
            })
            ->all();

        return view('pages.distributor_available_orders', compact('orders'));
    }

    public function acceptOrder($id)
    {
        if (!Auth::check()) {
            return back()->with('error', 'Please login as distributor to accept orders.');
        }

        $delivery = Delivery::query()->where('order_id', $id)->firstOrFail();
        $business = $this->currentDistributorBusiness();

        if (!$business) {
            return back()->with('error', 'Distributor business profile is missing.');
        }

        if ($delivery->distributor_id && $delivery->distributor_id !== $business->id) {
            return back()->with('error', 'Unauthorized: This order belongs to another distributor.');
        }

        $delivery->update([
            'distributor_id' => $business->id,
            'delivery_status' => 'Preparing',
        ]);

        return back()->with('success', 'Order accepted for delivery.');
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'step' => 'required|in:Preparing,On the Way,Delivered',
        ]);

        if (!Auth::check()) {
            return back()->with('error', 'Please login as distributor to update status.');
        }

        $delivery = Delivery::query()->where('order_id', $id)->firstOrFail();
        $business = $this->currentDistributorBusiness();

        if (!$business) {
            return back()->with('error', 'Distributor business profile is missing.');
        }

        if ($delivery->distributor_id && $delivery->distributor_id !== $business->id) {
            return back()->with('error', 'Unauthorized: This order belongs to another distributor.');
        }

        $delivery->update([
            'distributor_id' => $business->id,
            'delivery_status' => $validated['step'],
            'actual_delivery_time' => $validated['step'] === 'Delivered' ? now() : null,
        ]);

        return back()->with('success', "Order status updated to {$validated['step']}.");
    }

    public function trackOrders()
    {
        $trackedOrders = $this->deliveryQuery()
            ->with(['order.items.product', 'order.supplierBusiness'])
            ->latest('id')
            ->get()
            ->map(function (Delivery $delivery) {
                $item = $delivery->order?->items->first();

                return [
                    'id' => $delivery->order_id,
                    'order_id' => $delivery->order?->order_number,
                    'supplier' => $delivery->order?->supplierBusiness?->business_name ?? 'Unassigned Supplier',
                    'product' => $item?->product ? $this->productName($item->product) : 'Unknown Product',
                    'status' => $this->deliveryBadgeStatus($delivery->delivery_status),
                    'eta' => optional($delivery->order?->created_at)->addDays(2)?->toDateString(),
                ];
            })
            ->all();

        return view('pages.distributor_track_orders', compact('trackedOrders'));
    }

    public function manageSuppliers()
    {
        $suppliers = $this->supplierCards();

        return view('pages.distributor_manage_suppliers', compact('suppliers'));
    }

    public function deliveryTracking($id)
    {
        $delivery = Delivery::query()
            ->where('order_id', $id)
            ->with(['order.items.product', 'order.supplierBusiness'])
            ->firstOrFail();

        $item = $delivery->order?->items->first();
        $supplierName = $delivery->order?->supplierBusiness?->business_name ?? 'Unassigned Supplier';

        $order = [
            'id' => $delivery->order_id,
            'order_id' => $delivery->order?->order_number,
            'supplier' => $supplierName,
            'product' => $item?->product ? $this->productName($item->product) : 'Unknown Product',
            'quantity' => (int) ($item?->quantity ?? 0),
            'eta' => optional($delivery->order?->created_at)->addDays(2)?->toDateString(),
            'route' => $supplierName . ' -> City Hub -> Main Store',
            'current_status' => $delivery->delivery_status,
        ];

        return view('pages.distributor_delivery_tracking', compact('order'));
    }

    public function profile()
    {
        return view('pages.profile');
    }

    private function currentDistributorBusiness(): ?Business
    {
        return Auth::user()?->business;
    }

    private function deliveryQuery()
    {
        $business = $this->currentDistributorBusiness();

        return Delivery::query()->when($business, function ($query) use ($business) {
            $query->where(function ($inner) use ($business) {
                $inner->whereNull('distributor_id')
                    ->orWhere('distributor_id', $business->id);
            });
        });
    }

    private function deliveryBadgeStatus(string $deliveryStatus): string
    {
        return match ($deliveryStatus) {
            'On the Way' => 'In Transit',
            'Delivered' => 'Delivered',
            default => 'Pending',
        };
    }

    private function supplierCards(): array
    {
        $catalog = EggProduct::query()->orderBy('id')->get()->map(fn (EggProduct $product) => $this->productName($product))->implode(', ');

        return Business::query()
            ->whereHas('user', fn ($query) => $query->where('role', 'supplier'))
            ->with('user')
            ->get()
            ->map(function (Business $business) use ($catalog) {
                return [
                    'name' => $business->business_name,
                    'status' => 'Active',
                    'rating' => 4.8,
                    'products' => $catalog,
                ];
            })
            ->all();
    }

    private function productName(EggProduct $product): string
    {
        return $product->category === 'Tray'
            ? 'Jumbo Eggs'
            : $product->category . ' Eggs';
    }
}
