@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px;">
        <h2 style="font-size: 1.8rem; color: #d32f2f; margin-bottom: 20px;">Create New Order</h2>

        <form action="{{ route('order-confirm') }}" method="POST">
            @csrf

            <!-- Egg Type Selection -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #d32f2f; font-weight: bold; margin-bottom: 10px;">Select Egg Type</label>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                    <label style="border: 2px solid #ddd; padding: 15px; border-radius: 4px; text-align: center; cursor: pointer;">
                        <input type="radio" name="egg_size" value="small" required style="margin-right: 5px;">
                        <span>Small (₱230/Tray)</span>
                    </label>
                    <label style="border: 2px solid #ddd; padding: 15px; border-radius: 4px; text-align: center; cursor: pointer;">
                        <input type="radio" name="egg_size" value="medium" required style="margin-right: 5px;">
                        <span>Medium (₱240/Tray)</span>
                    </label>
                    <label style="border: 2px solid #ddd; padding: 15px; border-radius: 4px; text-align: center; cursor: pointer;">
                        <input type="radio" name="egg_size" value="large" required style="margin-right: 5px;">
                        <span>Large (₱250/Tray)</span>
                    </label>
                    <label style="border: 2px solid #ddd; padding: 15px; border-radius: 4px; text-align: center; cursor: pointer;">
                        <input type="radio" name="egg_size" value="xl" required style="margin-right: 5px;">
                        <span>XL (₱260/Tray)</span>
                    </label>
                    <label style="border: 2px solid #ddd; padding: 15px; border-radius: 4px; text-align: center; cursor: pointer;">
                        <input type="radio" name="egg_size" value="jumbo" required style="margin-right: 5px;">
                        <span>Jumbo (₱280/Tray)</span>
                    </label>
                </div>
            </div>

            <!-- Quantity Input -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #d32f2f; font-weight: bold; margin-bottom: 10px;">Quantity (Trays)</label>
                <input type="number" name="quantity" min="1" placeholder="Enter quantity" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;" required>
            </div>

            <!-- Delivery Address -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #d32f2f; font-weight: bold; margin-bottom: 10px;">Delivery Address</label>
                <input type="text" name="address" placeholder="Street address" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; margin-bottom: 10px;" required>
                <input type="text" name="city" placeholder="City" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; margin-bottom: 10px;" required>
                <input type="text" name="postal_code" placeholder="Postal Code" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;" required>
            </div>

            <!-- Preferred Delivery Date -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #d32f2f; font-weight: bold; margin-bottom: 10px;">Preferred Delivery Date</label>
                <input type="date" name="delivery_date" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;" required>
            </div>

            <!-- Order Summary (Read-only) -->
            <div style="background: #f5f5f5; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                <h4 style="color: #d32f2f; margin: 0 0 10px 0;">Order Summary</h4>
                <p style="margin: 5px 0;"><strong>Estimated subtotal:</strong> <span id="subtotal">₱0.00</span></p>
                <p style="margin: 5px 0;"><strong>Delivery fee:</strong> ₱50.00</p>
                <p style="margin: 5px 0; border-top: 1px solid #ddd; padding-top: 10px; margin-top: 10px;"><strong>Total:</strong> <span id="total">₱50.00</span></p>
            </div>

            <button type="submit" style="width: 100%; background-color: #d32f2f; color: white; padding: 12px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Review Order</button>
        </form>
    </div>
</div>

<script>
    document.querySelector('form').addEventListener('change', function() {
        let price = 0;
        const sizeMap = { small: 230, medium: 240, large: 250, xl: 260, jumbo: 280 };
        const selected = document.querySelector('input[name="egg_size"]:checked');
        const quantity = document.querySelector('input[name="quantity"]').value || 0;
        
        if (selected) {
            price = sizeMap[selected.value] * quantity;
        }
        
        document.getElementById('subtotal').textContent = '₱' + price.toFixed(2);
        document.getElementById('total').textContent = '₱' + (price + 50).toFixed(2);
    });
</script>
@endsection