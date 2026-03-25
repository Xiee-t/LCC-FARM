@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Welcome Section -->
    <div style="background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%); color: white; padding: 30px; border-radius: 8px; margin-bottom: 30px;">
        <h2 style="margin: 0 0 10px 0;">Welcome back, {{ $identity }}!</h2>
        <p style="margin: 0; opacity: 0.9;">Role: <strong>{{ ucfirst($role) }}</strong></p>
    </div>

    <!-- Quick Actions -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <a href="{{ route('place-order') }}" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-decoration: none; text-align: center; transition: all 0.3s;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📦</div>
            <h4 style="color: #d32f2f; margin: 0 0 5px 0;">Place Order</h4>
            <p style="color: #666; font-size: 0.9rem; margin: 0;">Create new order</p>
        </a>
        <a href="{{ route('my-orders') }}" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-decoration: none; text-align: center; transition: all 0.3s;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📋</div>
            <h4 style="color: #d32f2f; margin: 0 0 5px 0;">My Orders</h4>
            <p style="color: #666; font-size: 0.9rem; margin: 0;">Track active orders</p>
        </a>
        <a href="{{ route('order-history') }}" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-decoration: none; text-align: center; transition: all 0.3s;">
            <div style="font-size: 2rem; margin-bottom: 10px;">📜</div>
            <h4 style="color: #d32f2f; margin: 0 0 5px 0;">Order History</h4>
            <p style="color: #666; font-size: 0.9rem; margin: 0;">View past orders</p>
        </a>
    </div>

    <!-- Available Products -->
    <h3 style="color: #d32f2f; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">Available Egg Products</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <div style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 10px;">🥚</div>
            <h4 style="color: #d32f2f; margin: 0 0 5px 0;">Small</h4>
            <p style="color: #666; margin: 0 0 10px 0;">₱230/Tray (Retail)</p>
            <p style="background-color: #4caf50; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; margin: 0; display: inline-block;">In Stock</p>
        </div>
        <div style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 10px;">🥚</div>
            <h4 style="color: #d32f2f; margin: 0 0 5px 0;">Medium</h4>
            <p style="color: #666; margin: 0 0 10px 0;">₱240/Tray (Retail)</p>
            <p style="background-color: #4caf50; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; margin: 0; display: inline-block;">In Stock</p>
        </div>
        <div style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 10px;">🥚</div>
            <h4 style="color: #d32f2f; margin: 0 0 5px 0;">Large</h4>
            <p style="color: #666; margin: 0 0 10px 0;">₱250/Tray (Retail)</p>
            <p style="background-color: #4caf50; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; margin: 0; display: inline-block;">In Stock</p>
        </div>
        <div style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 10px;">🥚</div>
            <h4 style="color: #d32f2f; margin: 0 0 5px 0;">XL</h4>
            <p style="color: #666; margin: 0 0 10px 0;">₱260/Tray (Retail)</p>
            <p style="background-color: #ff9800; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; margin: 0; display: inline-block;">Low Stock</p>
        </div>
        <div style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center;">
            <div style="font-size: 2rem; margin-bottom: 10px;">🥚</div>
            <h4 style="color: #d32f2f; margin: 0 0 5px 0;">Jumbo</h4>
            <p style="color: #666; margin: 0 0 10px 0;">₱280/Tray (Retail)</p>
            <p style="background-color: #ff9800; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem; margin: 0; display: inline-block;">Low Stock</p>
        </div>
    </div>

    <!-- Notifications Summary -->
    <div style="background: #fff5f5; border-left: 4px solid #d32f2f; padding: 15px; border-radius: 4px;">
        <h4 style="color: #d32f2f; margin: 0 0 10px 0;">📢 Notifications</h4>
        <p style="margin: 5px 0;">✓ Order #1001 delivered successfully</p>
        <p style="margin: 5px 0;">✓ New wholesale pricing available (min. 10 trays)</p>
    </div>
</div>
@endsection