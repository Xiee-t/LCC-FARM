@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1100px; margin: 0 auto; padding: 20px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="margin: 0 0 4px 0; color: #333; font-size: 1.6rem; font-weight: 600;">Track Orders</h1>
            <p style="margin: 0; color: #666; font-size: 0.95rem;">Monitor the status of your supplier orders</p>
        </div>
        <a href="{{ route('distributor-dashboard') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.9rem; font-weight: 600;">← Back to Dashboard</a>
    </div>

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 0; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Order ID</th>
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Supplier</th>
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Product</th>
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Status</th>
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Expected Arrival</th>
                    <th style="padding: 14px 16px; text-align: left; color: #333; font-weight: 600; font-size: 0.9rem;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trackedOrders as $order)
                    <tr style="border-bottom: 1px solid #e0e0e0; transition: background 0.2s;">
                        <td style="padding: 14px 16px; font-weight: 600; color: #d32f2f;">{{ $order['order_id'] }}</td>
                        <td style="padding: 14px 16px; color: #333;">{{ $order['supplier'] }}</td>
                        <td style="padding: 14px 16px; color: #333;">{{ $order['product'] }}</td>
                        <td style="padding: 14px 16px;">
                            <span style="display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: 600; color: white; {{ $order['status'] === 'In Transit' ? 'background: #5a7fa0;' : ($order['status'] === 'Delivered' ? 'background: #2e7d32;' : 'background: #e6b800; color: #333;') }}">{{ $order['status'] }}</span>
                        </td>
                        <td style="padding: 14px 16px; color: #333;">{{ $order['eta'] }}</td>
                        <td style="padding: 14px 16px;">
                            <a href="{{ route('distributor-delivery-tracking', ['id' => $order['id']]) }}" style="color: #d32f2f; text-decoration: none; font-weight: 600; font-size: 0.9rem;">View Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('components.footer')