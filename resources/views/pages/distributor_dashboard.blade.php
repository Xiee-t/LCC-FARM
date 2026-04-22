@extends('layouts.app')

@section('content')

{{-- Ensure these paths match your actual folder structure (e.g., resources/views/components/...) --}}
@include('components.distributor_theme')
@include('components.dashboard_navbar')

<div class="dist-page">
    <div class="dist-shell" style="padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Welcome back, Distributor!</h1>
                    <p>Your dashboard is optimized for fast decisions. Tap a card to filter the order list by status.</p>
                </div>
            </div>
        </section>

        <div class="dist-metrics-grid">
            <div class="dist-metric-card" onclick="filterTable('Pending')" role="button" tabindex="0" aria-label="Filter to pending orders">
                <h4>Pending Orders</h4>
                <p class="dist-metric-value">{{ $stats['pending_orders'] }}</p>
            </div>
            <div class="dist-metric-card" onclick="filterTable('All')" role="button" tabindex="0" aria-label="Show all orders this month">
                <h4>Orders This Month</h4>
                <p class="dist-metric-value">{{ $stats['total_orders_month'] }}</p>
            </div>
            <div class="dist-metric-card" onclick="filterTable('All')" role="button" tabindex="0" aria-label="Show total revenue this month">
                <h4>Revenue This Month</h4>
                <p class="dist-metric-value">₱{{ number_format($stats['total_revenue']) }}</p>
            </div>
            <div class="dist-metric-card" onclick="filterTable('All')" role="button" tabindex="0" aria-label="Show active suppliers">
                <h4>Active Suppliers</h4>
                <p class="dist-metric-value">{{ $stats['active_suppliers'] }}</p>
            </div>
        </div>

        <section class="dist-card dist-card-padded" style="margin-bottom: 24px;">
            <h3 class="dist-section-title">Recent Orders from Suppliers</h3>
            <div class="dist-filters">
                <button type="button" onclick="filterTable('All')" class="dist-pill-btn dist-pill-btn-neutral">All</button>
                <button type="button" onclick="filterTable('Pending')" class="dist-pill-btn dist-pill-btn-warn">Pending</button>
                <button type="button" onclick="filterTable('Delivered')" class="dist-pill-btn dist-pill-btn-success">Delivered</button>
                <button type="button" onclick="filterTable('In Transit')" class="dist-pill-btn dist-pill-btn-info">In Transit</button>
            </div>

            <div class="dist-table-wrap">
                <table class="dist-table data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Expected Delivery</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr data-status="{{ $order['status'] }}">
                            <td class="dist-order-id">{{ $order['order_id'] }}</td>
                            <td>{{ $order['supplier'] }}</td>
                            <td>{{ $order['product'] }}</td>
                            <td>{{ $order['quantity'] }}</td>
                            <td>{{ $order['expected_delivery'] }}</td>
                            <td>
                                <span class="dist-status-chip {{ $order['status'] === 'Pending' ? 'dist-status-pending' : ($order['status'] === 'Delivered' ? 'dist-status-delivered' : 'dist-status-in-transit') }}">
                                    {{ $order['status'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="dist-card dist-card-padded">
            <h3 class="dist-section-title">Your Active Suppliers</h3>
            <div class="dist-grid">
                @foreach($suppliers as $supplier)
                    <article class="dist-card dist-card-padded" style="box-shadow: none;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; margin-bottom: 12px;">
                            <h4 style="margin: 0;">{{ $supplier['name'] }}</h4>
                            <span class="dist-status-chip dist-status-delivered">{{ $supplier['status'] }}</span>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div>
                                <p class="dist-muted" style="margin: 0 0 2px 0; font-size: 0.84rem;">Rating</p>
                                <p style="margin: 0; font-weight: 700;">{{ $supplier['rating'] }}/5.0</p>
                            </div>
                            <div>
                                <p class="dist-muted" style="margin: 0 0 2px 0; font-size: 0.84rem;">Products</p>
                                <p style="margin: 0; font-weight: 700;">{{ $supplier['products'] }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
    @include('components.footer')
</div>

<script>
    function filterTable(status) {
        const rows = document.querySelectorAll('.data-table tbody tr');
        rows.forEach(row => {
            if (status === 'All') {
                row.style.display = '';
            } else {
                const rowStatus = row.getAttribute('data-status');
                row.style.display = rowStatus === status ? '' : 'none';
            }
        });
    }
</script>

@endsection