@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h2 style="font-size: 1.8rem; color: #d32f2f; margin-bottom: 20px;">My Active Orders</h2>

    <div style="display: grid; gap: 20px;">
        <!-- Order Card 1 -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; border-left: 4px solid #4caf50;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 15px; align-items: center;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Order ID</p>
                    <p style="margin: 0; font-weight: bold;">#ORD-2026-003</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Product</p>
                    <p style="margin: 0; font-weight: bold;">Large (25 Trays)</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Expected Delivery</p>
                    <p style="margin: 0; font-weight: bold;">Mar 28</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Status</p>
                    <p style="background-color: #4caf50; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.85rem; margin: 0; display: inline-block;">Processing</p>
                </div>
                <a href="{{ route('order-details', 3) }}" style="background-color: #d32f2f; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-size: 0.9rem;">View</a>
            </div>
        </div>

        <!-- Order Card 2 -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; border-left: 4px solid #ff9800;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 15px; align-items: center;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Order ID</p>
                    <p style="margin: 0; font-weight: bold;">#ORD-2026-001</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Product</p>
                    <p style="margin: 0; font-weight: bold;">Medium (15 Trays)</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Expected Delivery</p>
                    <p style="margin: 0; font-weight: bold;">Mar 26</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Status</p>
                    <p style="background-color: #ff9800; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.85rem; margin: 0; display: inline-block;">In Transit</p>
                </div>
                <a href="{{ route('order-details', 1) }}" style="background-color: #d32f2f; color: white; padding: 8px 15px; border-radius: 4px; text-decoration: none; font-size: 0.9rem;">View</a>
            </div>
        </div>
    </div>

    <p style="text-align: center; color: #666; margin-top: 30px;">
        <a href="{{ route('place-order') }}" style="color: #d32f2f; text-decoration: none;">Place a new order</a>
    </p>
</div>
@endsection