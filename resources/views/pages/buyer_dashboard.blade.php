@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1200px; margin: 0 auto; padding: 20px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="margin: 0; color: #d32f2f; font-size: 2rem;">Welcome back, {{ explode('@', $identity)[0] ? ucfirst(explode('@', $identity)[0]) : ucfirst($identity) }}!</h1>
            <p style="margin: 4px 0 0 0; color: #555; font-size: 1rem;">Fast order path for buyers. Pick a tray size and checkout efficiently.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('order-history') }}" style="background: #d32f2f; color: #fff; padding: 10px 16px; border-radius: 8px; font-weight: 700; text-decoration: none; box-shadow: 0 3px 6px rgba(0,0,0,0.12);">Order History</a>
            <a href="{{ route('my-orders') }}" style="background: #333; color: #fff; padding: 10px 16px; border-radius: 8px; font-weight: 700; text-decoration: none; box-shadow: 0 3px 6px rgba(0,0,0,0.12);">My Orders</a>
            <a href="{{ route('place-order') }}" style="background: #d32f2f; color: #fff; padding: 10px 16px; border-radius: 8px; font-weight: 700; text-decoration: none; box-shadow: 0 3px 6px rgba(0,0,0,0.12);">Quick Order</a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 28px;">
        <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; border: 1px solid #e0e0e0;">
            <h3 style="margin: 0 0 15px; color: #333; font-weight: 600;">Quick Summary</h3>
            <div style="display: grid; gap: 12px; font-size: 0.95rem;">
                <div style="display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px solid #f0f0f0;">
                    <span style="color: #666;">Egg sizes available</span>
                    <span style="color: #333; font-weight: 600;">{{ count($products) }} options</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px solid #f0f0f0;">
                    <span style="color: #666;">Trays in stock</span>
                    <span style="color: #333; font-weight: 600;">{{ $totalStock }} units</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: #666;">Pending deliveries</span>
                    <span style="color: #333; font-weight: 600;">{{ $activeOrderCount }} orders</span>
                </div>
            </div>
        </div>

        <div style="background: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; border: 1px solid #e0e0e0;">
            <h3 style="margin: 0 0 10px; color: #333; font-weight: 600;">Best Value</h3>
            <p style="margin: 0 0 12px; color: #555; font-size: 0.95rem; line-height: 1.5;">Medium (15 Trays) is our most popular pick with balanced price and inventory.</p>
            <a href="{{ route('place-order') }}?size=medium" style="display: inline-block; background: #d32f2f; color: #fff; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Order Medium</a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 30px;">
        @foreach($products as $product)
            @php
                $isBestValue = $product['id'] === 'medium';
            @endphp
            <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; border: 1px solid #e0e0e0; transition: all 0.2s ease;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <h3 style="margin: 0; color: #333; font-size: 1.05rem; font-weight: 600;">{{ $product['name'] }}</h3>
                    @if($isBestValue)
                        <span style="background: #d32f2f; color: white; border-radius: 999px; padding: 4px 10px; font-size: 0.75rem; font-weight: 700; white-space: nowrap;">Best Value</span>
                    @endif
                </div>
                <p style="margin: 0 0 8px; color: #2e7d32; font-size: 1.25rem; font-weight: 800;">₱{{ number_format($product['price']) }}<span style="font-size: 0.9rem; color:#888;">/Tray</span></p>
                <p style="margin: 0 0 15px; color: #666; font-size: 0.9rem;">Stock: <strong>{{ $product['stock'] }} units</strong></p>
                <a href="{{ route('place-order') }}?size={{ $product['id'] }}" style="display: block; background: #d32f2f; color: #fff; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; text-align: center; font-size: 0.9rem;">Order this size</a>
            </div>
        @endforeach
    </div>

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; border: 1px solid #e0e0e0;">
        <h3 style="margin: 0 0 10px; color: #333; font-weight: 600;">Quick Navigation</h3>
        <p style="margin: 0 0 15px; color: #555; font-size: 0.95rem;">Fast access to your orders and account.</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
            <a href="{{ route('my-orders') }}" style="background: #d32f2f; color: #fff; text-decoration: none; padding: 12px; border-radius: 6px; text-align: center; font-weight: 600; font-size: 0.9rem; transition: all 0.2s;">My Active Orders</a>
            <a href="{{ route('order-history') }}" style="background: #666; color: #fff; text-decoration: none; padding: 12px; border-radius: 6px; text-align: center; font-weight: 600; font-size: 0.9rem; transition: all 0.2s;">Order History</a>
            <a href="{{ route('buyer-profile') }}" style="background: #666; color: #fff; text-decoration: none; padding: 12px; border-radius: 6px; text-align: center; font-weight: 600; font-size: 0.9rem; transition: all 0.2s;">My Profile</a>
        </div>
    </div>
</div>

@include('components.footer')
