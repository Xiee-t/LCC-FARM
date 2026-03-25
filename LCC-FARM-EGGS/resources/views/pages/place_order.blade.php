@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">
    <div style="width: 100%; max-width: 800px; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px;">
        <h2 style="font-size: 2rem; color: #d32f2f; margin-bottom: 20px;">Place Order</h2>
        <p style="margin-bottom: 15px;">Select egg size, quantity, and submit your order request.</p>

        <form>
            <div style="display: grid; gap: 15px; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
                <select style="padding: 10px; border: 1px solid #ddd; border-radius: 4px;" name="size">
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                    <option value="xl">XL</option>
                    <option value="jumbo">Jumbo</option>
                </select>
                <input type="number" min="1" placeholder="Quantity (trays)" class="form-control" style="padding: 10px; border: 1px solid #ddd; border-radius: 4px;" />
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <button type="submit" style="background-color: #d32f2f; color: white; padding: 12px 40px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Submit Order</button>
            </div>
        </form>

        <p style="margin-top: 20px;">Once submitted, orders are processed by the team. For now this is a static demonstration page.</p>
    </div>
</div>
@endsection