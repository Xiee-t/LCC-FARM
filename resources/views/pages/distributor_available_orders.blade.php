@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

<div class="dist-page">
    <div class="dist-shell">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Available Orders</h1>
                    <p>Browse and accept incoming orders from your suppliers.</p>
                </div>
                <a href="{{ route('distributor-dashboard') }}" class="dist-back-link">Back to Dashboard</a>
            </div>
        </section>

        @if(session('success'))
            <div class="dist-subtle-banner" style="background: #e6f5e8; border-color: #c7e3cb; color: #1f5b22;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="dist-subtle-banner" style="background: #fef2f2; border-color: #fecaca; color: #dc2626;">
                {{ session('error') }}
            </div>
        @endif

        <section class="dist-card dist-card-padded">
            <div class="dist-table-wrap">
                <table class="dist-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Supplier</th>
                            <th>Delivery Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="dist-order-id">{{ $order['order_id'] }}</td>
                                <td>{{ $order['product'] }}</td>
                                <td>{{ $order['quantity'] }} Trays</td>
                                <td>{{ $order['supplier'] }}</td>
                                <td>{{ $order['delivery'] }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                        <form method="POST" action="{{ route('distributor-accept-order', ['id' => $order['id']]) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dist-pill-btn dist-pill-btn-success">Accept</button>
                                        </form>
                                        <a href="{{ route('distributor-delivery-tracking', ['id' => $order['id']]) }}" class="dist-pill-btn dist-pill-btn-primary">View</a>
                                    </div>
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