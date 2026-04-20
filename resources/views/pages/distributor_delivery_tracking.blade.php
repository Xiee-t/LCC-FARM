@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

<div class="dist-page">
    <div class="dist-shell" style="max-width: 1000px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h2>Delivery Tracking</h2>
                    <p>Follow this delivery from preparation to arrival.</p>
                </div>
                <a href="{{ route('distributor-available-orders') }}" class="dist-back-link">Available Orders</a>
            </div>
        </section>

        <section class="dist-card dist-card-padded" style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 12px 0;">{{ $order['order_id'] }} - {{ $order['product'] }}</h3>
            <div class="dist-info-list">
                <p>Supplier: <strong>{{ $order['supplier'] }}</strong></p>
                <p>Quantity: <strong>{{ $order['quantity'] }} Trays</strong></p>
                <p>Expected Delivery: <strong>{{ $order['eta'] }}</strong></p>
                <p>Route: <strong>{{ $order['route'] }}</strong></p>
            </div>
        </section>

        <section class="dist-card dist-card-padded">
            <h3 style="margin: 0 0 12px 0;">Status</h3>
            @php
                $steps = ['Preparing', 'On the Way', 'Delivered'];
            @endphp
            <div class="dist-status-tracker">
                @foreach($steps as $step)
                    @php
                        $isActive = $order['current_status'] === $step || ($order['current_status'] !== 'Preparing' && $step === 'Preparing');
                        $stepClass = $isActive ? 'dist-status-step--active' : '';
                    @endphp
                    <div class="dist-status-step {{ $stepClass }}">
                        {{ $step }}
                    </div>
                @endforeach
            </div>
        </section>
    </div>
    @include('components.footer')
</div>

@endsection