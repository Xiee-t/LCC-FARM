@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h2 style="font-size: 1.8rem; color: #d32f2f; margin-bottom: 20px;">Order History</h2>

    @if(empty($orders))
        <div style="text-align: center; padding: 40px 20px; background: #fff4f4; border: 1px solid #f5c6cb; border-radius: 8px; color: #d32f2f;">
            <h3 style="margin: 0 0 10px;">No past orders yet</h3>
            <p style="margin: 0 0 15px; color: #6f1d1b;">Place your first order and it will appear here.</p>
            <a href="{{ route('place-order') }}" style="background: #d32f2f; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: bold;">Place your first order</a>
        </div>
    @else
        <div style="display: grid; gap: 15px;">
            @foreach($orders as $order)
                @php
                    $status = $order['status'] ?? 'Delivered';
                    $statusBg = $status === 'Delivered' ? '#2e7d32' : ($status === 'In Transit' ? '#5a7fa0' : '#1976d2');
                @endphp
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 15px; align-items: center;">
                        <div>
                            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Order ID</p>
                            <p style="margin: 0; font-weight: bold;">#{{ $order['order_id'] }}</p>
                        </div>
                        <div>
                            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Product</p>
                            <p style="margin: 0; font-weight: bold;">{{ $order['product'] }}</p>
                        </div>
                        <div>
                            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Date</p>
                            <p style="margin: 0; font-weight: bold;">{{ $order['completed_at'] }}</p>
                        </div>
                        <div>
                            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Total</p>
                            <p style="margin: 0; font-weight: bold;">PHP {{ number_format($order['total'], 2) }}</p>
                            <span style="display: inline-block; margin-top: 6px; background: {{ $statusBg }}; color: white; border-radius: 12px; padding: 2px 10px; font-size: 0.75rem;">{{ $status }}</span>
                        </div>
                        <a href="{{ route('place-order', ['size' => $order['egg_size_key'], 'qty' => $order['quantity']]) }}" style="background-color: #d32f2f; color: white; padding: 8px 15px; border-radius: 4px; font-size: 0.9rem; text-decoration: none; text-align: center;">Quick Order Again</a>
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
@endsection
