@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

@php
    $statusClass = $order['status'] === 'Delivered'
        ? 'dist-status-delivered'
        : ($order['status'] === 'In Transit' ? 'dist-status-in-transit' : 'dist-status-pending');
@endphp

<div class="dist-page">
    <div class="dist-shell" style="max-width: 1040px; padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Order Details</h1>
                    <p>Review your order summary, delivery address, and current fulfillment status.</p>
                </div>
                <a href="{{ route('my-orders') }}" class="dist-back-link">Back to Orders</a>
            </div>
        </section>

        <section class="dist-card dist-card-padded" style="display: grid; gap: 20px;">
            <div class="order-details-grid">
                <div class="order-details-stat">
                    <p class="dist-muted" style="margin: 0 0 6px;">Order ID</p>
                    <h3 style="margin: 0;">{{ $order['order_id'] }}</h3>
                </div>
                <div class="order-details-stat">
                    <p class="dist-muted" style="margin: 0 0 6px;">Order Date</p>
                    <h3 style="margin: 0;">{{ $order['order_date'] }}</h3>
                </div>
                <div class="order-details-stat">
                    <p class="dist-muted" style="margin: 0 0 6px;">Expected Delivery</p>
                    <h3 style="margin: 0;">{{ $order['expected_delivery'] }}</h3>
                </div>
                <div class="order-details-stat">
                    <p class="dist-muted" style="margin: 0 0 10px;">Status</p>
                    <span class="dist-status-chip {{ $statusClass }}">{{ $order['status'] }}</span>
                </div>
            </div>

            <div class="order-details-panel">
                <h3 class="dist-section-title">Product Details</h3>
                <div class="order-details-grid order-details-grid--compact">
                    <div>
                        <p class="dist-muted" style="margin: 0 0 6px;">Product</p>
                        <p style="margin: 0; font-weight: 700;">{{ $order['product'] }}</p>
                    </div>
                    <div>
                        <p class="dist-muted" style="margin: 0 0 6px;">Unit Price</p>
                        <p style="margin: 0; font-weight: 700;">PHP {{ number_format($order['unit_price'], 2) }}</p>
                    </div>
                    <div>
                        <p class="dist-muted" style="margin: 0 0 6px;">Quantity</p>
                        <p style="margin: 0; font-weight: 700;">{{ $order['quantity'] }} trays</p>
                    </div>
                </div>
            </div>

            <div class="order-details-panel">
                <h3 class="dist-section-title">Delivery Address</h3>
                <p style="margin: 0 0 8px;">{{ $order['address'] }}</p>
                <p class="dist-muted" style="margin: 0;">{{ $order['city'] }}</p>
            </div>

            <div class="order-details-footer">
                <div class="order-details-footer-actions">
                    <a href="{{ route('my-orders') }}" class="dist-pill-btn dist-pill-btn-neutral">Back to Orders</a>
                    <a href="{{ route('place-order') }}" class="dist-pill-btn dist-pill-btn-primary">Place New Order</a>
                </div>

                <div class="order-details-total-wrap">
                    <div class="order-details-total-card">
                        <div class="order-details-total-row">
                            <span class="dist-muted">Subtotal</span>
                            <strong>PHP {{ number_format($order['subtotal'], 2) }}</strong>
                        </div>
                        <div class="order-details-total-row">
                            <span class="dist-muted">Delivery Fee</span>
                            <strong>PHP {{ number_format($order['delivery_fee'], 2) }}</strong>
                        </div>
                        <div class="order-details-total-row order-details-total-row--grand">
                            <span>Total</span>
                            <strong>PHP {{ number_format($order['total'], 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('components.footer')
</div>

<style>
    .order-details-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .order-details-grid--compact {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .order-details-stat {
        padding: 18px;
        border: 1px solid #efe7e2;
        border-radius: 16px;
        background: #fffaf6;
    }

    .order-details-panel {
        padding: 20px;
        border: 1px solid #efe7e2;
        border-radius: 16px;
        background: #fbf7f4;
    }

    .order-details-footer {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        align-items: end;
        gap: 24px;
        min-height: 0;
    }

    .order-details-footer-actions {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
        align-self: end;
    }

    .order-details-total-wrap {
        display: flex;
        justify-content: flex-end;
        align-self: start;
        margin-top: 0;
    }

    .order-details-total-card {
        width: 100%;
        border: 1px solid #efe7e2;
        border-radius: 18px;
        background: #fff;
        padding: 20px;
        box-shadow: var(--dist-shadow-soft);
    }

    .order-details-total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 6px 0;
        margin: 0;
    }

    .order-details-total-row--grand {
        margin-top: 0;
        padding-top: 12px;
        border-top: 1px solid #eadfd8;
        font-size: 1.05rem;
        color: var(--dist-primary);
    }

    @media (max-width: 900px) {
        .order-details-grid,
        .order-details-grid--compact {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .order-details-grid,
        .order-details-grid--compact {
            grid-template-columns: 1fr;
        }

        .order-details-footer {
            grid-template-columns: 1fr;
            min-height: 0;
        }

        .order-details-footer-actions {
            order: 2;
        }

        .order-details-total-wrap {
            justify-content: stretch;
            order: 1;
        }

        .order-details-total-card {
            width: 100%;
            min-height: 0;
        }
    }
</style>
@endsection
