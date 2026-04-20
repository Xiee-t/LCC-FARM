@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px;">
        <h2 style="font-size: 1.8rem; color: #d32f2f; margin-bottom: 20px;">Create New Order</h2>

        @if ($errors->any())
            <div style="background: #fff4f4; border: 1px solid #f5c6cb; color: #b71c1c; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                <strong>Please fix the following:</strong>
                <ul style="margin: 8px 0 0 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('order-confirm') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #d32f2f; font-weight: bold; margin-bottom: 10px;">Select Egg Type</label>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px;">
                    @foreach (($products ?? []) as $product)
                        <label style="border: 2px solid #ddd; padding: 15px; border-radius: 4px; text-align: center; cursor: pointer;">
                            <input type="radio" name="egg_size" value="{{ $product['id'] }}" required style="margin-right: 5px;" {{ old('egg_size', $prefill['egg_size'] ?? null) === $product['id'] ? 'checked' : '' }}>
                            <span>{{ $product['name'] }} (PHP {{ number_format($product['price']) }}/Tray)</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #d32f2f; font-weight: bold; margin-bottom: 10px;">Quantity (Trays)</label>
                <input type="number" name="quantity" min="1" placeholder="Enter quantity" value="{{ old('quantity', $prefill['quantity'] ?? 1) }}" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #d32f2f; font-weight: bold; margin-bottom: 10px;">Delivery Location</label>
                <input type="text" name="address" placeholder="Street address" value="{{ old('address', $prefill['address'] ?? '') }}" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; margin-bottom: 10px;" required>
                <input type="text" name="city" placeholder="City" value="{{ old('city', $prefill['city'] ?? '') }}" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; margin-bottom: 10px;" required>
                <input type="text" name="postal_code" placeholder="Postal Code" value="{{ old('postal_code', $prefill['postal_code'] ?? '') }}" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;" required>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; color: #d32f2f; font-weight: bold; margin-bottom: 10px;">Preferred Delivery Date</label>
                <input type="date" name="delivery_date" value="{{ old('delivery_date', $prefill['delivery_date'] ?? '') }}" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;" required>
            </div>

            <div style="background: #f5f5f5; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                <h4 style="color: #d32f2f; margin: 0 0 10px 0;">Order Summary</h4>
                <p style="margin: 5px 0;"><strong>Estimated subtotal:</strong> <span id="subtotal">PHP 0.00</span></p>
                <p style="margin: 5px 0;"><strong>Delivery fee:</strong> PHP 50.00</p>
                <p style="margin: 5px 0; border-top: 1px solid #ddd; padding-top: 10px; margin-top: 10px;"><strong>Total:</strong> <span id="total">PHP 50.00</span></p>
            </div>

            <button type="submit" style="width: 100%; background-color: #d32f2f; color: white; padding: 12px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Review Order</button>
        </form>
    </div>
</div>

<script>
    const sizeMap = {
        @foreach (($products ?? []) as $product)
            "{{ $product['id'] }}": {{ $product['price'] }},
        @endforeach
    };

    function updateTotals() {
        let price = 0;
        const selected = document.querySelector('input[name="egg_size"]:checked');
        const quantity = Number(document.querySelector('input[name="quantity"]').value || 0);

        if (selected && sizeMap[selected.value]) {
            price = sizeMap[selected.value] * quantity;
        }

        document.getElementById('subtotal').textContent = 'PHP ' + price.toFixed(2);
        document.getElementById('total').textContent = 'PHP ' + (price + 50).toFixed(2);
    }

    document.querySelector('form').addEventListener('change', updateTotals);
    document.querySelector('input[name="quantity"]').addEventListener('input', updateTotals);
    updateTotals();
</script>
@endsection
