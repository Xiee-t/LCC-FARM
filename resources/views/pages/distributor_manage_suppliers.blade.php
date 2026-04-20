@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

<div class="dist-page">
    <div class="dist-shell">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Manage Suppliers</h1>
                    <p>View supplier performance and keep active partnerships healthy.</p>
                </div>
                <a href="{{ route('distributor-dashboard') }}" class="dist-back-link">Back to Dashboard</a>
            </div>
        </section>

        <section class="dist-grid">
            @foreach($suppliers as $supplier)
                <article class="dist-card dist-card-padded">
                    <h3 style="margin: 0 0 12px 0;">{{ $supplier['name'] }}</h3>
                    <div style="display: grid; gap: 10px; margin-bottom: 16px; font-size: 0.9rem;">
                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                            <span class="dist-muted">Products</span>
                            <span style="font-weight: 700;">{{ $supplier['products'] }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                            <span class="dist-muted">Rating</span>
                            <span style="font-weight: 700;">{{ $supplier['rating'] }}/5.0</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                            <span class="dist-muted">Status</span>
                            <span class="dist-status-chip dist-status-delivered">{{ $supplier['status'] }}</span>
                        </div>
                    </div>
                    <a href="#" class="dist-pill-btn dist-pill-btn-primary" style="display: block; width: 100%; text-align: center;">Contact Supplier</a>
                </article>
            @endforeach
        </section>
    </div>
    @include('components.footer')
</div>

@endsection