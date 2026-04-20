@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<style>
    .status-badge { padding: 5px 12px; border-radius: 4px; font-size: 0.9rem; margin: 0; display: inline-block; font-weight: bold; color: white; }
    .status-processing { background-color: #4caf50; }
    .status-other { background-color: #ff9800; }
</style>

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="font-size: 1.8rem; color: #d32f2f; margin: 0;">Order Details</h2>
        <a href="{{ route('my-orders') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">← Back to Orders</a>
    </div>

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px;">
        <!-- Order Header -->
        <div style="border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Order ID</p>
                    <p style="margin: 0; font-weight: bold; font-size: 1.1rem;">{{ $order['order_id'] }}</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Order Date</p>
                    <p style="margin: 0; font-weight: bold; font-size: 1.1rem;">{{ $order['order_date'] }}</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Expected Delivery</p>
                    <p style="margin: 0; font-weight: bold; font-size: 1.1rem;">{{ $order['expected_delivery'] }}</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Status</p>
                    <span class="status-badge {{ $order['status'] === 'Processing' ? 'status-processing' : 'status-other' }}">{{ $order['status'] }}</span>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div style="margin-bottom: 30px;">
            <h3 style="font-size: 1.2rem; color: #333; margin-bottom: 15px;">Product Details</h3>
            <div style="background: #f9f9f9; padding: 20px; border-radius: 6px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                    <div>
                        <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Product</p>
                        <p style="margin: 0; font-weight: bold; font-size: 1rem;">{{ $order['product'] }}</p>
                    </div>
                    <div>
                        <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Unit Price</p>
                        <p style="margin: 0; font-weight: bold; font-size: 1rem;">₱{{ number_format($order['unit_price']) }}</p>
                    </div>
                    <div>
                        <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Quantity</p>
                        <p style="margin: 0; font-weight: bold; font-size: 1rem;">{{ $order['quantity'] }} Trays</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Address -->
        <div style="margin-bottom: 30px;">
            <h3 style="font-size: 1.2rem; color: #333; margin-bottom: 15px;">Delivery Address</h3>
            <div style="background: #f9f9f9; padding: 20px; border-radius: 6px;">
                <p style="margin: 0 0 10px 0; color: #333;">{{ $order['address'] }}</p>
                <p style="margin: 0; color: #666;">{{ $order['city'] }}</p>
            </div>
        </div>

        <!-- Price Summary -->
        <div style="border-top: 2px solid #eee; padding-top: 20px;">
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 40px; max-width: 400px; margin-left: auto;">
                <p style="margin: 0; color: #666;">Subtotal:</p>
                <p style="margin: 0; font-weight: bold;">₱{{ number_format($order['subtotal']) }}</p>

                <p style="margin: 0; color: #666;">Delivery Fee:</p>
                <p style="margin: 0; font-weight: bold;">₱{{ number_format($order['delivery_fee']) }}</p>

                <p style="margin: 10px 0 0 0; color: #333; font-size: 1.1rem; border-top: 2px solid #eee; padding-top: 10px;">Total:</p>
                <p style="margin: 10px 0 0 0; font-weight: bold; font-size: 1.1rem; border-top: 2px solid #eee; padding-top: 10px; color: #d32f2f;">₱{{ number_format($order['total']) }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #eee; display: flex; gap: 10px;">
            <a href="{{ route('my-orders') }}" style="background-color: #f0f0f0; color: #333; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">Back to Orders</a>
            <a href="{{ route('place-order') }}" style="background-color: #d32f2f; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: bold;">Place New Order</a>
        </div>
    </div>
</div>

@endsection
