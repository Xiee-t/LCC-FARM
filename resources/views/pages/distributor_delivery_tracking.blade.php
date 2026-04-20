@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<style>
    .status-tracker { display: flex; gap: 12px; }
    .status-step { padding: 12px 16px; border-radius: 8px; border: 1px solid #ccc; text-align: center; width: 120px; }
    .status-step--active { background: #d1e7dd; color: #0f5132; border-color: #0f5132; }
    .status-step--inactive { background: #f0f0f0; color: #666; border-color: #ccc; }
</style>

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="color: #1f618d;">Delivery Tracking</h2>
        <a href="{{ route('distributor-available-orders') }}" style="color: #d32f2f; text-decoration: none;">← Available Orders</a>
    </div>

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px;">
        <h3 style="margin: 0 0 12px 0;">{{ $order['order_id'] }} - {{ $order['product'] }}</h3>
        <p style="margin: 6px 0;">Supplier: <strong>{{ $order['supplier'] }}</strong></p>
        <p style="margin: 6px 0;">Quantity: <strong>{{ $order['quantity'] }} Trays</strong></p>
        <p style="margin: 6px 0;">Expected Delivery: <strong>{{ $order['eta'] }}</strong></p>
        <p style="margin: 6px 0;">Route: <strong>{{ $order['route'] }}</strong></p>
    </div>

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
        <h3 style="margin: 0 0 12px 0;">Status</h3>
        @php
            $steps = ['Preparing', 'On the Way', 'Delivered'];
        @endphp
        <div class="status-tracker">
            @foreach($steps as $step)
                @php
                    $isActive = $order['current_status'] === $step || ($order['current_status'] !== 'Preparing' && $step === 'Preparing');
                    $stepClass = $isActive ? 'status-step--active' : 'status-step--inactive';
                @endphp
                <div class="status-step {{ $stepClass }}">
                    {{ $step }}
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection