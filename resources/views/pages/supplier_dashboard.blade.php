@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

@php
    $pendingOrders = count(array_filter($recentOrders, fn($order) => $order['status'] === 'Pending'));
@endphp

<div class="dist-page">
    <div class="dist-shell" style="padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Supplier Dashboard</h1>
                    <p>Monitor inventory health, check incoming orders, and keep fulfillment moving from one place.</p>
                </div>
                <a href="{{ route('supplier-inventory') }}" class="dist-back-link">Manage Inventory</a>
            </div>
        </section>

        <section class="dist-card dist-card-padded" style="margin-bottom: 24px;">
            @include('components.inventory_alerts', ['alerts' => $alerts])
        </section>

        <div class="dist-metrics-grid">
            <div class="dist-metric-card">
                <h4>Total Products</h4>
                <p class="dist-metric-value">{{ count($inventory) }}</p>
            </div>
            <div class="dist-metric-card">
                <h4>Low Stock</h4>
                <p class="dist-metric-value" style="color: #d18a00;">{{ count($alerts) }}</p>
            </div>
            <div class="dist-metric-card">
                <h4>Pending Orders</h4>
                <p class="dist-metric-value">{{ $pendingOrders }}</p>
            </div>
        </div>

        <section class="dist-card dist-card-padded">
            <div style="display: flex; justify-content: space-between; gap: 16px; align-items: flex-start; flex-wrap: wrap; margin-bottom: 16px;">
                <div>
                    <h3 class="dist-section-title">Recent Orders</h3>
                    <p class="dist-muted" style="margin: 0;">Latest requests assigned to your supplier account.</p>
                </div>
                <a href="{{ route('supplier-orders') }}" class="dist-pill-btn dist-pill-btn-primary">View All Orders</a>
            </div>

            @if(empty($recentOrders))
                <div class="dist-subtle-banner" style="margin-bottom: 0;">
                    There are no supplier orders yet. New buyer purchases will appear here once assigned.
                </div>
            @else
                <div class="dist-table-wrap">
                    <table class="dist-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Customer</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                @php
                                    $statusClass = match ($order['status']) {
                                        'Completed' => 'dist-status-delivered',
                                        'In Progress' => 'dist-status-in-transit',
                                        default => 'dist-status-pending',
                                    };
                                @endphp
                                <tr>
                                    <td class="dist-order-id">{{ $order['order_id'] }}</td>
                                    <td>{{ $order['product'] }}</td>
                                    <td>{{ $order['quantity'] }}</td>
                                    <td>{{ $order['customer'] }}</td>
                                    <td>
                                        <span class="dist-status-chip {{ $statusClass }}">{{ $order['status'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
    @include('components.footer')
</div>
@endsection
