@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <style>
        .order-card { background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; }
        .order-card-delivered { border-left: 4px solid #2e7d32; }
        .order-card-in-transit { border-left: 4px solid #5a7fa0; }
        .order-card-processing { border-left: 4px solid #1976d2; }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; color: white; font-weight: 600; }
        .status-delivered { background: #2e7d32; }
        .status-in-transit { background: #5a7fa0; }
        .status-processing { background: #1976d2; }
    </style>

    <h2 style="font-size: 1.8rem; color: #d32f2f; margin-bottom: 20px;">My Active Orders</h2>

    @if(session('success'))
        <div style="background: #e8f8f5; border: 1px solid #2ecc71; color: #1b4f72; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px;">{{ session('success') }}</div>
    @endif

    @if(empty($orders))
        <div style="text-align: center; padding: 40px 20px; background: #fff4f4; border: 1px solid #f5c6cb; border-radius: 8px; color: #d32f2f;">
            <h3 style="margin: 0 0 10px;">Your basket is empty!</h3>
            <p style="margin: 0 0 15px; color: #6f1d1b;">It looks like your basket is empty! Time to get crackin' on a new order.</p>
            <a href="{{ route('place-order') }}" style="background: #d32f2f; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: bold;">Create your first order</a>
        </div>
    @else
        <div style="display: grid; gap: 20px;">
            @foreach($orders as $order)
                @php
                    $statusClass = 'status-processing';
                    $cardClass = 'order-card-processing';

                    if ($order['status'] === 'Delivered') {
                        $statusClass = 'status-delivered';
                        $cardClass = 'order-card-delivered';
                    } elseif ($order['status'] === 'In Transit') {
                        $statusClass = 'status-in-transit';
                        $cardClass = 'order-card-in-transit';
                    }
                @endphp
                <div class="order-card {{ $cardClass }}">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 15px; align-items: center;">
                        <div>
                            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Order ID</p>
                            <p style="margin: 0; font-weight: bold;">{{ $order['order_id'] }}</p>
                        </div>
                        <div>
                            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Product</p>
                            <p style="margin: 0; font-weight: bold;">{{ $order['egg_size'] }} ({{ $order['quantity'] }} Trays)</p>
                        </div>
                        <div>
                            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Expected Delivery</p>
                            <p style="margin: 0; font-weight: bold;">{{ date('M d', strtotime($order['delivery_date'])) }}</p>
                        </div>
                        <div>
                            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Status</p>
                            <p class="status-badge {{ $statusClass }}">{{ $order['status'] }}</p>
                        </div>
                        <a href="{{ route('order-details', $order['id'] ?? ($loop->index + 1)) }}" style="background-color: #d32f2f; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-size: 0.9rem;">View</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <p style="text-align: center; color: #666; margin-top: 30px;">
        <a href="{{ route('place-order') }}" style="color: #d32f2f; text-decoration: none;">Place a new order</a>
    </p>
</div>

@include('components.footer')