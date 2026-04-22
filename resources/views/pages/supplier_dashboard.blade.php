@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h2 style="font-size: 1.8rem; color: #333; margin-bottom: 30px;">Supplier Dashboard</h2>

    <!-- Inventory Alerts -->
    @include('components.inventory_alerts', ['alerts' => $alerts])

    <!-- Quick Stats -->
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 30px;">
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
            <h4>Total Products</h4>
            <p style="font-size: 2rem; font-weight: bold;">{{ count($inventory) }}</p>
        </div>
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
            <h4>Low Stock</h4>
            <p style="font-size: 2rem; font-weight: bold; color: #ff9800;">{{ count($alerts) }}</p>
        </div>
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
            <h4>Pending Orders</h4>
            <p style="font-size: 2rem; font-weight: bold;">{{ count(array_filter($recentOrders, fn($o) => $o['status'] === 'Pending')) }}</p>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
        <h3 style="margin-bottom: 15px;">Recent Orders</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f5f5f5;">
                    <th style="padding: 12px; text-align: left;">Order ID</th>
                    <th style="padding: 12px; text-align: left;">Product</th>
                    <th style="padding: 12px; text-align: left;">Quantity</th>
                    <th style="padding: 12px; text-align: left;">Customer</th>
                    <th style="padding: 12px; text-align: left;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px; font-weight: bold;">{{ $order['order_id'] }}</td>
                    <td style="padding: 12px;">{{ $order['product'] }}</td>
                    <td style="padding: 12px;">{{ $order['quantity'] }}</td>
                    <td style="padding: 12px;">{{ $order['customer'] }}</td>
                    <td style="padding: 12px;">
                        <span style="padding: 4px 8px; border-radius: 4px; background: #e3f2fd; color: #1976d2; font-size: 0.8rem;">{{ $order['status'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('components.footer')

@endsection

