@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

<div class="dist-page">
    <div class="dist-shell" style="padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>My Active Orders</h1>
                    <p>Orders still in preparation or transit appear here. Delivered orders move to History.</p>
                </div>
                <a href="{{ route('place-order') }}" class="dist-back-link">Place Order</a>
            </div>
        </section>

        @if(session('success'))
            <div class="dist-subtle-banner" style="background: #e6f5e8; border-color: #c7e3cb; color: #1f5b22;">
                {{ session('success') }}
            </div>
        @endif

        @if(empty($orders))
            <section class="dist-card dist-card-padded">
                <h3 class="dist-section-title">No Active Orders</h3>
                <p class="dist-muted">Your current queue is empty. New purchases will show here until they are delivered.</p>
                <a href="{{ route('place-order') }}" class="dist-pill-btn dist-pill-btn-primary">Create Your First Order</a>
            </section>
        @else
            <section class="dist-card dist-card-padded">
                <div class="dist-table-wrap">
                    <table class="dist-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Expected Delivery</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                @php
                                    $statusClass = $order['status'] === 'Delivered'
                                        ? 'dist-status-delivered'
                                        : ($order['status'] === 'In Transit' ? 'dist-status-in-transit' : 'dist-status-pending');
                                @endphp
                                <tr>
                                    <td class="dist-order-id">{{ $order['order_id'] }}</td>
                                    <td>{{ $order['egg_size'] }} ({{ $order['quantity'] }} trays)</td>
                                    <td>{{ date('M d', strtotime($order['delivery_date'])) }}</td>
                                    <td>
                                        <span class="dist-status-chip {{ $statusClass }}">{{ $order['status'] }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('order-details', $order['id']) }}" class="dist-pill-btn dist-pill-btn-primary">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>
    @include('components.footer')
</div>
@endsection
