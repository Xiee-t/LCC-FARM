@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<style>
    .order-status-badge { padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; display: inline-block; border: 1px solid #d32f2f; background-color: #ffffff; color: #d32f2f; }
    .status-pending, .status-in-progress, .status-completed { background-color: #ffffff; color: #d32f2f; border: 1px solid #d32f2f; }

    .inventory-status { padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; display: inline-block; border: 1px solid #d32f2f; background-color: #ffffff; color: #d32f2f; }
    .inventory-good, .inventory-low, .inventory-out { background-color: #ffffff; color: #d32f2f; border: 1px solid #d32f2f; }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h2 style="font-size: 1.8rem; color: #d32f2f; margin-bottom: 30px;">Supplier Dashboard</h2>

    <!-- Alerts Section -->
    <div style="margin-bottom: 30px;">
        <h3 style="font-size: 1.2rem; color: #333; margin-bottom: 15px;">Inventory Alerts</h3>
        @include('components.inventory_alerts', ['alerts' => $alerts])
    </div>

    <!-- Dashboard Grid -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
        <!-- Quick Stats -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
            <h3 style="font-size: 1.1rem; color: #333; margin-bottom: 15px;">Quick Stats</h3>
            <div style="display: grid; gap: 15px;">
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f9f9f9; border-radius: 4px;">
                    <p style="margin: 0; color: #666;">Total Products</p>
                    <p style="margin: 0; font-weight: bold; font-size: 1.2rem;">{{ count($inventory) }}</p>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f9f9f9; border-radius: 4px;">
                    <p style="margin: 0; color: #d32f2f;">Low Stock Items</p>
                    <p style="margin: 0; font-weight: bold; font-size: 1.2rem; color: #d32f2f;">{{ count($alerts) }}</p>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #f9f9f9; border-radius: 4px;">
                    <p style="margin: 0; color: #666;">Pending Orders</p>
                    <p style="margin: 0; font-weight: bold; font-size: 1.2rem;">{{ count(array_filter($recentOrders, fn($o) => $o['status'] === 'Pending')) }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
            <h3 style="font-size: 1.1rem; color: #333; margin-bottom: 15px;">Quick Actions</h3>
            <div style="display: grid; gap: 10px;">
                <a href="{{ route('supplier-inventory') }}" style="background-color: #d32f2f; color: white; padding: 12px 20px; border-radius: 4px; text-decoration: none; font-weight: bold; text-align: center;">Manage Inventory</a>
                <a href="{{ route('supplier-orders') }}" style="background-color: #d32f2f; color: white; padding: 12px 20px; border-radius: 4px; text-decoration: none; font-weight: bold; text-align: center;">View Orders</a>
                <a href="{{ route('supplier-profile') }}" style="background-color: #d32f2f; color: white; padding: 12px 20px; border-radius: 4px; text-decoration: none; font-weight: bold; text-align: center;">View Profile</a>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 30px;">
        <h3 style="font-size: 1.2rem; color: #333; margin-bottom: 15px;">Recent Orders</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #eee;">
                    <th style="text-align: left; padding: 12px; color: #666; font-weight: bold;">Order ID</th>
                    <th style="text-align: left; padding: 12px; color: #666; font-weight: bold;">Product</th>
                    <th style="text-align: left; padding: 12px; color: #666; font-weight: bold;">Quantity</th>
                    <th style="text-align: left; padding: 12px; color: #666; font-weight: bold;">Customer</th>
                    <th style="text-align: left; padding: 12px; color: #666; font-weight: bold;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px; font-weight: bold;">{{ $order['order_id'] }}</td>
                    <td style="padding: 12px;">{{ $order['product'] }}</td>
                    <td style="padding: 12px;">{{ $order['quantity'] }} Trays</td>
                    <td style="padding: 12px;">{{ $order['customer'] }}</td>
                    <td style="padding: 12px;">
                        @php
                            $statusClass = 'status-pending';
                            if($order['status'] === 'In Progress') $statusClass = 'status-in-progress';
                            elseif($order['status'] === 'Completed') $statusClass = 'status-completed';
                        @endphp
                        <span class="order-status-badge {{ $statusClass }}">{{ $order['status'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 15px; text-align: center;">
            <a href="{{ route('supplier-orders') }}" style="color: #d32f2f; text-decoration: none; font-weight: bold;">View All Orders →</a>
        </div>
    </div>

    <!-- Current Inventory Summary -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
        <h3 style="font-size: 1.2rem; color: #333; margin-bottom: 15px;">Current Inventory</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #eee;">
                    <th style="text-align: left; padding: 12px; color: #666; font-weight: bold;">Product</th>
                    <th style="text-align: left; padding: 12px; color: #666; font-weight: bold;">Stock</th>
                    <th style="text-align: left; padding: 12px; color: #666; font-weight: bold;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventory as $item)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">{{ $item['product'] }}</td>
                    <td style="padding: 12px; font-weight: bold;">{{ $item['stock'] }} units</td>
                    <td style="padding: 12px;">
                        @php
                            $inventoryClass = 'inventory-good';
                            if($item['status'] === 'Low Stock') $inventoryClass = 'inventory-low';
                            elseif($item['status'] === 'Out of Stock') $inventoryClass = 'inventory-out';
                        @endphp
                        <span class="inventory-status {{ $inventoryClass }}">{{ $item['status'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 15px; text-align: center;">
            <a href="{{ route('supplier-inventory') }}" style="color: #d32f2f; text-decoration: none; font-weight: bold;\">Update Inventory →</a>
        </div>
    </div>
</div>

@include('components.footer')

