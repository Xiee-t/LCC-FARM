@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="font-size: 3rem; margin-bottom: 15px;">✓</div>
            <h2 style="font-size: 1.8rem; color: #d32f2f; margin-bottom: 10px;">Got it! Order on the way.</h2>
            <p style="color: #666; margin: 0;">We've sent your order to the farm. We'll let you know when the eggs are on the move.</p>
        </div>

        <div style="background: #f5f5f5; padding: 20px; border-radius: 4px; margin-bottom: 20px;">
            <h4 style="color: #d32f2f; margin: 0 0 15px 0;">Order Details</h4>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <p style="color: #666; margin: 0 0 5px 0;">Order ID</p>
                    <p style="margin: 0; font-weight: bold;">#{{ session('current_order')['order_id'] ?? 'ORD-2026-003' }}</p>
                </div>
                <div>
                    <p style="color: #666; margin: 0 0 5px 0;">Order Date</p>
                    <p style="margin: 0; font-weight: bold;">{{ session('current_order')['order_date'] ? date('F d, Y', strtotime(session('current_order')['order_date'])) : 'March 25, 2026' }}</p>
                </div>
                <div>
                    <p style="color: #666; margin: 0 0 5px 0;">Egg Size</p>
                    <p style="margin: 0; font-weight: bold;">{{ session('current_order')['egg_size'] ?? 'Large' }}</p>
                </div>
                <div>
                    <p style="color: #666; margin: 0 0 5px 0;">Quantity</p>
                    <p style="margin: 0; font-weight: bold;">{{ session('current_order')['quantity'] ?? 25 }} Trays</p>
                </div>
                <div>
                    <p style="color: #666; margin: 0 0 5px 0;">Total Amount</p>
                    <p style="margin: 0; font-weight: bold; color: #d32f2f;">₱{{ number_format(session('current_order')['total'] ?? 6300, 2) }}</p>
                </div>
                <div>
                    <p style="color: #666; margin: 0 0 5px 0;">Expected Delivery</p>
                    <p style="margin: 0; font-weight: bold;">{{ session('current_order')['delivery_date'] ? date('F d, Y', strtotime(session('current_order')['delivery_date'])) : 'March 28, 2026' }}</p>
                </div>
            </div>
        </div>

        <div style="background: #fff5f5; border-left: 4px solid #d32f2f; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <h4 style="color: #d32f2f; margin: 0 0 10px 0;">What's Next?</h4>
            <ul style="margin: 0; padding-left: 20px;">
                <li style="margin: 5px 0;">Your order will be processed within 24 hours</li>
                <li style="margin: 5px 0;">A distributor will be assigned soon</li>
                <li style="margin: 5px 0;">You'll receive a delivery confirmation SMS</li>
                <li style="margin: 5px 0;">Track your order in "My Orders" section</li>
            </ul>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('dashboard') }}" style="flex: 1; display: inline-block; text-align: center; background-color: #d32f2f; color: white; padding: 12px; border-radius: 4px; text-decoration: none; font-weight: bold;">Back to Dashboard</a>
            <a href="{{ route('my-orders') }}" style="flex: 1; display: inline-block; text-align: center; background-color: #666; color: white; padding: 12px; border-radius: 4px; text-decoration: none; font-weight: bold;">View My Orders</a>
        </div>
    </div>
</div>
@endsection