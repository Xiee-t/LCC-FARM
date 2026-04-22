@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

<div class="dist-page">
    <div class="dist-shell" style="padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Buyer Dashboard</h1>
                    <p>Track your active deliveries, browse the current catalog, and place a new order without leaving the portal.</p>
                </div>
                <a href="{{ route('place-order') }}" class="dist-back-link">Quick Order</a>
            </div>
        </section>

        <div class="dist-metrics-grid">
            <div class="dist-metric-card">
                <h4>Available Products</h4>
                <p class="dist-metric-value">{{ count($products) }}</p>
            </div>
            <div class="dist-metric-card">
                <h4>Trays in Stock</h4>
                <p class="dist-metric-value">{{ $totalStock }}</p>
            </div>
            <div class="dist-metric-card">
                <h4>Active Orders</h4>
                <p class="dist-metric-value">{{ $activeOrderCount }}</p>
            </div>
        </div>

        <section class="dist-card dist-card-padded" style="margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; gap: 16px; align-items: flex-start; flex-wrap: wrap;">
                <div>
                    <h3 class="dist-section-title">Catalog</h3>
                    <p class="dist-muted" style="margin: 0;">Fresh pricing and live inventory from the normalized product catalog.</p>
                </div>
                <div class="dist-filters" style="margin-bottom: 0;">
                    <a href="{{ route('my-orders') }}" class="dist-pill-btn dist-pill-btn-neutral">Active Orders</a>
                    <a href="{{ route('order-history') }}" class="dist-pill-btn dist-pill-btn-neutral">History</a>
                </div>
            </div>
        </section>

        <div class="dist-grid">
            @forelse($products as $product)
                <article class="dist-card dist-card-padded">
                    <div style="display: flex; justify-content: space-between; gap: 12px; align-items: flex-start; margin-bottom: 14px;">
                        <div>
                            <p class="dist-muted" style="margin: 0 0 4px;">Egg Size</p>
                            <h3 style="margin: 0;">{{ $product['size'] }}</h3>
                        </div>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end;">
                            <span class="dist-status-chip dist-status-info">{{ $product['name'] }}</span>
                            @if($product['size'] === 'Medium')
                                <span class="dist-status-chip dist-status-pending">Best Value</span>
                            @endif
                        </div>
                    </div>

                    <p style="margin: 0 0 8px; font-size: 1.5rem; font-weight: 800; color: var(--dist-primary);">
                        PHP {{ number_format($product['price'], 2) }}
                    </p>
                    <p class="dist-muted" style="margin: 0 0 18px;">{{ $product['stock'] }} trays available</p>

                    <a href="{{ route('place-order', ['size' => $product['id']]) }}" class="dist-pill-btn dist-pill-btn-primary" style="width: 100%;">
                        Order This Size
                    </a>
                </article>
            @empty
                <section class="dist-card dist-card-padded">
                    <h3 class="dist-section-title">No Products Available</h3>
                    <p class="dist-muted" style="margin: 0;">Inventory has not been seeded yet.</p>
                </section>
            @endforelse
        </div>
    </div>
    @include('components.footer')
</div>
@endsection
