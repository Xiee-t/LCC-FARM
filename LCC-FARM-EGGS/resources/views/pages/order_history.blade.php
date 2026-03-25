@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h2 style="font-size: 1.8rem; color: #d32f2f; margin-bottom: 20px;">Order History</h2>

    <div style="display: grid; gap: 15px;">
        <!-- Completed Order 1 -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 15px; align-items: center;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Order ID</p>
                    <p style="margin: 0; font-weight: bold;">#ORD-2026-002</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Product</p>
                    <p style="margin: 0; font-weight: bold;">XL (10 Trays)</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Completed</p>
                    <p style="margin: 0; font-weight: bold;">Mar 20, 2026</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Total</p>
                    <p style="margin: 0; font-weight: bold;">₱2,600.00</p>
                </div>
                <button onclick="repeatOrder('xL', 10)" style="background-color: #d32f2f; color: white; padding: 8px 15px; border: none; border-radius: 4px; font-size: 0.9rem; cursor: pointer;">Repeat</button>
            </div>
        </div>

        <!-- Completed Order 2 -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 15px; align-items: center;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Order ID</p>
                    <p style="margin: 0; font-weight: bold;">#ORD-2026-000</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Product</p>
                    <p style="margin: 0; font-weight: bold;">Small (20 Trays)</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Completed</p>
                    <p style="margin: 0; font-weight: bold;">Mar 10, 2026</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Total</p>
                    <p style="margin: 0; font-weight: bold;">₱4,650.00</p>
                </div>
                <button onclick="repeatOrder('small', 20)" style="background-color: #d32f2f; color: white; padding: 8px 15px; border: none; border-radius: 4px; font-size: 0.9rem; cursor: pointer;">Repeat</button>
            </div>
        </div>

        <!-- Completed Order 3 -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 15px; align-items: center;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Order ID</p>
                    <p style="margin: 0; font-weight: bold;">#ORD-2025-999</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Product</p>
                    <p style="margin: 0; font-weight: bold;">Jumbo (5 Trays)</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Completed</p>
                    <p style="margin: 0; font-weight: bold;">Mar 01, 2026</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Total</p>
                    <p style="margin: 0; font-weight: bold;">₱1,450.00</p>
                </div>
                <button onclick="repeatOrder('jumbo', 5)" style="background-color: #d32f2f; color: white; padding: 8px 15px; border: none; border-radius: 4px; font-size: 0.9rem; cursor: pointer;">Repeat</button>
            </div>
        </div>
    </div>

    <p style="text-align: center; color: #666; margin-top: 30px;">
        <a href="{{ route('place-order') }}" style="color: #d32f2f; text-decoration: none;">Place a new order</a>
    </p>
</div>

<script>
    function repeatOrder(size, qty) {
        window.location.href = "{{ route('place-order') }}?size=" + size + "&qty=" + qty;
    }
</script>
@endsection