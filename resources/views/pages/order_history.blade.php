@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

<div class="dist-page">
    <div class="dist-shell" style="padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Order History</h1>
                    <p>Delivered orders live here as your completed purchase archive.</p>
                </div>
                <a href="{{ route('place-order') }}" class="dist-back-link">Order Again</a>
            </div>
        </section>

        @if(empty($orders))
            <section class="dist-card dist-card-padded">
                <h3 class="dist-section-title">No Completed Orders Yet</h3>
                <p class="dist-muted">Once an order is delivered, it will move from My Orders into this history page.</p>
                <a href="{{ route('place-order') }}" class="dist-pill-btn dist-pill-btn-primary">Place Your First Order</a>
            </section>
        @else
            <section class="dist-card dist-card-padded">
                <div class="dist-table-wrap">
                    <table class="dist-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Completed</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="dist-order-id">{{ $order['order_id'] }}</td>
                                    <td>{{ $order['product'] }} ({{ $order['quantity'] }} trays)</td>
                                    <td>{{ $order['completed_at'] }}</td>
                                    <td>PHP {{ number_format($order['total'], 2) }}</td>
                                    <td>
                                        <a href="{{ route('place-order', ['size' => $order['egg_size_key']]) }}" class="dist-pill-btn dist-pill-btn-success">Order Again</a>
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
