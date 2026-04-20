@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<style>
    :root {
        --brand-red: #A30000;
        --brand-dark: #660000;
    }

    .body-font { font-family: 'Inter', 'Roboto', sans-serif; }

    .status-chip {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 0.81rem;
        font-weight: 700;
        color: #fff;
    }

    .status-pending { background: #e6b800; color: #fff; }
    .status-delivered { background: #2e7d32; }
    .status-in-transit { background: #5a7fa0; }

    .metrics-grid, .actions-grid, .supplier-grid { display: grid; gap: 16px; }
    .metrics-grid { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 24px; }
    .metric-card, .action-card { border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,.07); background: #fff; transition: transform .25s ease, box-shadow .25s ease; }
    .metric-card:hover, .action-card:hover { transform: translateY(-4px); box-shadow: 0 8px 18px rgba(0,0,0,.12); cursor: pointer; }
    .metric-content { padding: 18px; }
    .metric-content h4 { margin: 0 0 6px 0; font-size: 0.9rem; color: var(--brand-dark); }
    .metric-content .value { font-size: 2rem; font-weight: 800; color: var(--brand-red); }

    .action-card { border-top: 4px solid var(--brand-red); }
    .action-card h5 { margin: 8px 0 6px 0; color: var(--brand-dark); font-size: 1rem; }
    .action-card p { margin: 0; color: #4a4a4a; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th, .data-table td { padding: 10px 12px; }
    .data-table tr:nth-child(even) { background: #fbfbfb; }
    .data-table tr:hover { background: #f4f7fb; }
    .data-table th { text-align: left; border-bottom: 2px solid #eee; color: #434343; }
    .data-table td.numeric { text-align: right; }

    .welcome-box { background: #fff4f4; padding: 16px 20px; border-radius: 8px; border: 1px solid #f2c0c0; }
</style>

<div class="body-font" style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Welcome Section -->
    <div class="welcome-box" style="margin-bottom: 24px;">
        <h3 style="margin: 0 0 8px 0; color: var(--brand-red); font-size: 1.4rem;">Welcome back, Distributor!</h3>
        <p style="margin: 0; color: #333;">Your dashboard is optimized for fast decisions — tap a card to filter the order list by status.</p>
    </div>

    <!-- Stats Grid -->
    <div class="metrics-grid">
        <div class="metric-card" onclick="filterTable('Pending')" style="cursor: pointer;">
            <div class="metric-content">
                <h4>Pending Orders</h4>
                <p class="value">{{ $stats['pending_orders'] }}</p>
            </div>
        </div>
        <div class="metric-card" onclick="filterTable('All')" style="cursor: pointer;">
            <div class="metric-content">
                <h4>Orders This Month</h4>
                <p class="value">{{ $stats['total_orders_month'] }}</p>
            </div>
        </div>
        <div class="metric-card" onclick="filterTable('All')" style="cursor: pointer;">
            <div class="metric-content">
                <h4>Revenue This Month</h4>
                <p class="value">₱{{ number_format($stats['total_revenue']) }}</p>
            </div>
        </div>
        <div class="metric-card" onclick="filterTable('All')" style="cursor: pointer;">
            <div class="metric-content">
                <h4>Active Suppliers</h4>
                <p class="value">{{ $stats['active_suppliers'] }}</p>
            </div>
        </div>
    </div>



    <!-- Recent Orders -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 30px;">
        <h3 style="font-size: 1.2rem; color: #333; margin-bottom: 15px;">Recent Orders from Suppliers</h3>
        <div style="margin-bottom: 10px; display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
            <button onclick="filterTable('All')" style="padding: 8px 14px; border-radius: 4px; background: #f0f0f0; border: 1px solid #ddd; cursor: pointer; font-size: 0.9rem; font-weight: 500;">All</button>
            <button onclick="filterTable('Pending')" style="padding: 8px 14px; border-radius: 4px; background: #e6b800; border: none; color: white; cursor: pointer; font-size: 0.9rem; font-weight: 500;">Pending</button>
            <button onclick="filterTable('Delivered')" style="padding: 8px 14px; border-radius: 4px; background: #2e7d32; border: none; color: white; cursor: pointer; font-size: 0.9rem; font-weight: 500;">Delivered</button>
            <button onclick="filterTable('In Transit')" style="padding: 8px 14px; border-radius: 4px; background: #5a7fa0; border: none; color: white; cursor: pointer; font-size: 0.9rem; font-weight: 500;">In Transit</button>
        </div>
        <table class="data-table" style="width: 100%; border-collapse: collapse;">
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
                <tr style="border-bottom: 1px solid #eee;" data-status="{{ $order['status'] }}">
                            <td style="padding: 12px; font-weight: bold;">{{ $order['order_id'] }}</td>
                    <td style="padding: 12px;">{{ $order['supplier'] }}</td>
                    <td style="padding: 12px;">{{ $order['product'] }}</td>
                    <td class="numeric" style="padding: 12px;">{{ $order['quantity'] }}</td>
                    <td style="padding: 12px;">{{ $order['expected_delivery'] }}</td>
                    <td style="padding: 12px; text-align: center;">
                        <span class="status-chip {{ $order['status'] === 'Pending' ? 'status-pending' : ($order['status'] === 'Delivered' ? 'status-delivered' : 'status-in-transit') }}">
                            {{ $order['status'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Suppliers Section -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
        <h3 style="font-size: 1.2rem; color: #333; margin-bottom: 15px;">Your Active Suppliers</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
            @foreach($suppliers as $supplier)
                <div style="padding: 16px; border: 1px solid #e0e0e0; border-radius: 8px; background: #fafafa; transition: all 0.2s ease;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                        <h4 style="margin: 0; color: #333; font-size: 1rem;">{{ $supplier['name'] }}</h4>
                        <span style="background: #2e7d32; color: white; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">{{ $supplier['status'] }}</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 0.9rem; margin-bottom: 12px;">
                        <div>
                            <p style="margin: 0 0 2px 0; color: #888;">Rating</p>
                            <p style="margin: 0; color: #333; font-weight: 600;">{{ $supplier['rating'] }}/5.0</p>
                        </div>
                        <div>
                            <p style="margin: 0 0 2px 0; color: #888;">Products</p>
                            <p style="margin: 0; color: #333; font-weight: 600;">{{ $supplier['products'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
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

@include('components.footer')

