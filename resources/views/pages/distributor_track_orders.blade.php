@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

<div class="dist-page">
    <div class="dist-shell">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Track Orders</h1>
                    <p>Monitor the status and delivery timeline of your supplier orders.</p>
                </div>
                <a href="{{ route('distributor-dashboard') }}" class="dist-back-link">Back to Dashboard</a>
            </div>
        </section>

        <section class="dist-card dist-card-padded">
            <div class="dist-table-wrap">
                <table class="dist-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th>Status</th>
                            <th>Expected Arrival</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trackedOrders as $order)
                            <tr>
                                <td class="dist-order-id">{{ $order['order_id'] }}</td>
                                <td>{{ $order['supplier'] }}</td>
                                <td>{{ $order['product'] }}</td>
                                <td>
                                    <span class="dist-status-chip {{ $order['status'] === 'In Transit' ? 'dist-status-in-transit' : ($order['status'] === 'Delivered' ? 'dist-status-delivered' : 'dist-status-pending') }}">{{ $order['status'] }}</span>
                                </td>
                                <td>{{ $order['eta'] }}</td>
                                <td>
                                    <a href="{{ route('distributor-delivery-tracking', ['id' => $order['id']]) }}" class="dist-pill-btn dist-pill-btn-primary">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    @include('components.footer')
</div>

@endsection