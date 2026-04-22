
@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #333; margin-bottom: 20px;">My Orders</h1>

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f5f5f5;">
                    <th style="padding: 12px;">Order ID</th>
                    <th style="padding: 12px;">Product</th>
                    <th style="padding: 12px;">Quantity</th>
                    <th style="padding: 12px;">Distributor</th>
                    <th style="padding: 12px;">Status</th>
                    <th style="padding: 12px;">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px; font-weight: bold;">{{ $order->order_id }}</td>
                    <td style="padding: 12px;">{{ $order->product }}</td>
                    <td style="padding: 12px;">{{ $order->quantity }} Trays</td>
                    <td style="padding: 12px;">Distributor</td>
                    <td style="padding: 12px;">
                        <span style="padding: 4px 8px; border-radius: 4px; background: #e3f2fd; color: #1976d2; font-size: 0.8rem;">{{ $order->status }}</span>
                    </td>

                    <td style="padding: 12px;">{{ date('M d', strtotime($order->created_at)) }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

