@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

@php
    $pendingCount = count(array_filter($orders, fn($order) => $order['status'] === 'Pending'));
    $inProgressCount = count(array_filter($orders, fn($order) => $order['status'] === 'In Progress'));
    $completedCount = count(array_filter($orders, fn($order) => $order['status'] === 'Completed'));
@endphp

<div class="dist-page">
    <div class="dist-shell" style="padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Incoming Orders</h1>
                    <p>Track incoming requests from buyers and keep each order moving through the supplier workflow.</p>
                </div>
                <a href="{{ route('supplier-dashboard') }}" class="dist-back-link">Back to Dashboard</a>
            </div>
        </section>

        <section class="dist-card dist-card-padded" style="margin-bottom: 24px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 14px; align-items: end;">
                <div>
                    <label class="dist-muted" style="display: block; margin-bottom: 8px; font-weight: 700;">Search Orders</label>
                    <input type="text" placeholder="Search by Order ID..." class="supplier-order-input">
                </div>
                <div>
                    <label class="dist-muted" style="display: block; margin-bottom: 8px; font-weight: 700;">Filter by Status</label>
                    <select class="supplier-order-input">
                        <option>All Orders</option>
                        <option>Pending</option>
                        <option>In Progress</option>
                        <option>Completed</option>
                    </select>
                </div>
                <button type="button" class="dist-pill-btn dist-pill-btn-primary" style="min-width: 180px; padding-block: 12px;">Apply Filters</button>
            </div>
        </section>

        <div class="dist-metrics-grid" style="grid-template-columns: repeat(4, minmax(180px, 1fr));">
            <div class="dist-metric-card">
                <h4>Total Orders</h4>
                <p class="dist-metric-value">{{ count($orders) }}</p>
            </div>
            <div class="dist-metric-card">
                <h4>Pending</h4>
                <p class="dist-metric-value" style="color: #d18a00;">{{ $pendingCount }}</p>
            </div>
            <div class="dist-metric-card">
                <h4>In Progress</h4>
                <p class="dist-metric-value" style="color: #2c7be5;">{{ $inProgressCount }}</p>
            </div>
            <div class="dist-metric-card">
                <h4>Completed</h4>
                <p class="dist-metric-value" style="color: #2e7d32;">{{ $completedCount }}</p>
            </div>
        </div>

        @if(empty($orders))
            <section class="dist-card dist-card-padded">
                <h3 class="dist-section-title">No Orders Yet</h3>
                <p class="dist-muted" style="margin: 0;">Incoming supplier orders will appear here once buyers start placing requests.</p>
            </section>
        @else
            <div class="dist-grid" style="grid-template-columns: 1fr;">
                @foreach($orders as $order)
                    @php
                        $statusClass = match ($order['status']) {
                            'Completed' => 'dist-status-delivered',
                            'In Progress' => 'dist-status-in-transit',
                            default => 'dist-status-pending',
                        };
                    @endphp
                    <section class="dist-card dist-card-padded supplier-order-card">
                        <div class="supplier-order-head">
                            <div class="supplier-order-meta">
                                <div>
                                    <p class="dist-muted supplier-order-label">Order ID</p>
                                    <p class="supplier-order-value">{{ $order['order_id'] }}</p>
                                </div>
                                <div>
                                    <p class="dist-muted supplier-order-label">Product</p>
                                    <p class="supplier-order-value">{{ $order['product'] }}</p>
                                </div>
                                <div>
                                    <p class="dist-muted supplier-order-label">Quantity</p>
                                    <p class="supplier-order-value">{{ $order['quantity'] }} trays</p>
                                </div>
                                <div>
                                    <p class="dist-muted supplier-order-label">Status</p>
                                    <span class="dist-status-chip {{ $statusClass }}">{{ $order['status'] }}</span>
                                </div>
                            </div>

                            <button
                                type="button"
                                class="dist-pill-btn dist-pill-btn-primary status-btn"
                                data-order-id="{{ $order['id'] }}"
                                data-order-label="{{ $order['order_id'] }}"
                                data-order-status="{{ $order['status'] }}">
                                Update Status
                            </button>
                        </div>

                        <div class="supplier-order-detail-grid">
                            <div>
                                <p class="dist-muted supplier-order-label">Customer</p>
                                <p class="supplier-order-detail">{{ $order['customer'] }}</p>
                            </div>
                            <div>
                                <p class="dist-muted supplier-order-label">Order Date</p>
                                <p class="supplier-order-detail">{{ $order['order_date'] }}</p>
                            </div>
                            <div>
                                <p class="dist-muted supplier-order-label">Expected Delivery</p>
                                <p class="supplier-order-detail">{{ $order['expected_delivery'] }}</p>
                            </div>
                        </div>
                    </section>
                @endforeach
            </div>
        @endif
    </div>
    @include('components.footer')
</div>

<div id="statusModal" class="supplier-modal" style="display: none;">
    <div class="supplier-modal-card">
        <h3 id="statusModalTitle" style="margin-top: 0; color: #7b2117;">Update Order Status</h3>
        <form id="statusForm" method="POST" action="">
            @csrf
            <div style="margin-bottom: 18px;">
                <label class="dist-muted" style="display: block; margin-bottom: 8px; font-weight: 700;">Current Status</label>
                <input type="text" id="currentStatus" readonly class="supplier-order-input" style="background: #f7f2ef;">
            </div>
            <div style="margin-bottom: 18px;">
                <label class="dist-muted" style="display: block; margin-bottom: 8px; font-weight: 700;">New Status</label>
                <select name="status" id="newStatus" required class="supplier-order-input">
                    <option value="">Select status</option>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <div class="dist-subtle-banner" style="margin-bottom: 18px;">
                Pending -> In Progress -> Completed
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="dist-pill-btn dist-pill-btn-primary" style="flex: 1;">Update Status</button>
                <button type="button" onclick="closeStatusModal()" class="dist-pill-btn dist-pill-btn-neutral" style="flex: 1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<style>
    .supplier-order-input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #dfd4ce;
        border-radius: 12px;
        background: #fff;
        font: inherit;
        box-sizing: border-box;
    }

    .supplier-order-card {
        display: grid;
        gap: 18px;
    }

    .supplier-order-head {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .supplier-order-meta {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        flex: 1;
    }

    .supplier-order-label {
        margin: 0 0 6px;
        font-size: 0.85rem;
    }

    .supplier-order-value {
        margin: 0;
        font-weight: 700;
        color: #2f2f2f;
    }

    .supplier-order-detail-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        padding: 16px;
        border-radius: 16px;
        background: #fbf7f4;
        border: 1px solid #efe7e2;
    }

    .supplier-order-detail {
        margin: 0;
        font-weight: 700;
        color: #2f2f2f;
    }

    .supplier-modal {
        position: fixed;
        inset: 0;
        background: rgba(34, 25, 20, 0.42);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .supplier-modal-card {
        width: min(100%, 460px);
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 24px 50px rgba(0, 0, 0, 0.2);
        border: 1px solid #efe7e2;
    }

    @media (max-width: 900px) {
        .supplier-order-meta {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .supplier-order-detail-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 700px) {
        .supplier-order-head {
            flex-direction: column;
        }

        .supplier-order-meta,
        .dist-metrics-grid[style] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<script>
function openStatusModal(id, orderId, currentStatus) {
    const modal = document.getElementById('statusModal');
    const form = document.getElementById('statusForm');
    const title = document.getElementById('statusModalTitle');
    const currentStatusInput = document.getElementById('currentStatus');
    const newStatusSelect = document.getElementById('newStatus');

    title.textContent = 'Update Status: ' + orderId;
    currentStatusInput.value = currentStatus;
    newStatusSelect.value = '';
    form.action = '/supplier/orders/' + id;

    modal.style.display = 'flex';
}

function closeStatusModal() {
    document.getElementById('statusModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.status-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            openStatusModal(button.dataset.orderId, button.dataset.orderLabel, button.dataset.orderStatus);
        });
    });
});

window.onclick = function(event) {
    const modal = document.getElementById('statusModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>
@endsection
