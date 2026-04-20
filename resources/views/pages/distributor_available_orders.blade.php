@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1100px; margin: 0 auto; padding: 20px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="margin: 0 0 4px 0; color: #333; font-size: 1.6rem; font-weight: 600;">Available Orders</h1>
            <p style="margin: 0; color: #666; font-size: 0.95rem;">Browse and accept orders from your suppliers</p>
        </div>
        <a href="{{ route('distributor-dashboard') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.9rem; font-weight: 600;">← Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div style="background-color: #d4edda; padding: 12px 16px; border-radius: 6px; color: #155724; border: 1px solid #c3e6cb; margin-bottom: 20px; font-size: 0.9rem;">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Order ID</th>
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Product</th>
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Quantity</th>
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Supplier</th>
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Delivery Date</th>
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr style="border-bottom: 1px solid #e0e0e0; transition: background 0.2s;">
                        <td style="padding: 14px 16px; font-weight: 600; color: #d32f2f;">{{ $order['order_id'] }}</td>
                        <td style="padding: 14px 16px; color: #333;">{{ $order['product'] }}</td>
                        <td style="padding: 14px 16px; color: #333;">{{ $order['quantity'] }} Trays</td>
                        <td style="padding: 14px 16px; color: #333;">{{ $order['supplier'] }}</td>
                        <td style="padding: 14px 16px; color: #333;">{{ $order['delivery'] }}</td>
                        <td style="padding: 14px 16px;">
                            <form method="POST" action="{{ route('distributor-accept-order', ['id' => $order['id']]) }}" style="display: inline;">
                                @csrf
                                <button type="submit" style="background-color: #2e7d32; color: white; border: none; padding: 8px 14px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 0.85rem; margin-right: 6px;">Accept</button>
                            </form>
                            <a href="{{ route('distributor-delivery-tracking', ['id' => $order['id']]) }}" style="color: #d32f2f; text-decoration: none; font-weight: 600; font-size: 0.85rem;">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('components.footer')

@endsection