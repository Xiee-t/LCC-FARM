@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">
    <div style="width: 100%; max-width: 720px; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px;">
        <h2 style="font-size: 2rem; color: #d32f2f; margin-bottom: 20px;">Dashboard</h2>
        <p style="margin-bottom: 20px;">Hello <strong>{{ $phone }}</strong>, role: <strong>{{ ucfirst($role) }}</strong>.</p>
        <p>Welcome to your dashboard. From here you can:</p>
        <ul>
            <li><a href="{{ route('place-order') }}" style="color: #d32f2f;">Place Order</a></li>
            <li><a href="{{ route('view-orders') }}" style="color: #d32f2f;">View Orders</a></li>
            <li><a href="{{ route('landing') }}" style="color: #d32f2f;">Return to Landing</a></li>
            <li><a href="{{ route('logout') }}" style="color: #d32f2f;">Logout</a></li>
        </ul>

        @if($role === 'supplier')
            <div style="margin-top: 20px; padding: 15px; background: #fff5f5; border: 1px solid #f6c6c6; border-radius: 6px;">
                <strong>Supplier panel:</strong> Manage inventory and set wholesale pricing.
            </div>
        @elseif($role === 'distributor')
            <div style="margin-top: 20px; padding: 15px; background: #fff5f5; border: 1px solid #f6c6c6; border-radius: 6px;">
                <strong>Distributor panel:</strong> Check bulk orders and delivery schedule.
            </div>
        @else
            <div style="margin-top: 20px; padding: 15px; background: #fff5f5; border: 1px solid #f6c6c6; border-radius: 6px;">
                <strong>Buyer panel:</strong> Browse egg sizes and place orders easily.
            </div>
        @endif
    </div>
</div>
@endsection