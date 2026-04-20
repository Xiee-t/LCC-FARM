@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<style>
    .stock-zero { color: #d32f2f; font-weight: bold; }
    .stock-low { color: #ff9800; font-weight: bold; }
    .stock-sufficient { color: #333; font-weight: normal; }

    .status-good { padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; background-color: #d1e7dd; color: #0f5132; display: inline-block; }
    .status-low { padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; background-color: #fff3cd; color: #856404; display: inline-block; }
    .status-out { padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; background-color: #f8d7da; color: #842029; display: inline-block; }

    .btn-update { background-color: #d32f2f; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 0.9rem; }
    .btn-update:hover { opacity: 0.9; }
</style>

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="font-size: 1.8rem; color: #d32f2f; margin: 0;">Inventory Management</h2>
        <a href="{{ route('supplier-dashboard') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">← Back to Dashboard</a>
    </div>

    <!-- Search and Filter -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Search Product</label>
                <input type="text" placeholder="Search inventory..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Filter by Status</label>
                <select style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <option>All Items</option>
                    <option>Good</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Inventory Table -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f9f9f9; border-bottom: 2px solid #eee;">
                    <th style="text-align: left; padding: 15px; color: #666; font-weight: bold;">Product</th>
                    <th style="text-align: left; padding: 15px; color: #666; font-weight: bold;">Current Stock</th>
                    <th style="text-align: left; padding: 15px; color: #666; font-weight: bold;">Min. Threshold</th>
                    <th style="text-align: left; padding: 15px; color: #666; font-weight: bold;">Unit Price</th>
                    <th style="text-align: left; padding: 15px; color: #666; font-weight: bold;">Status</th>
                    <th style="text-align: left; padding: 15px; color: #666; font-weight: bold;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventory as $item)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px; font-weight: bold;">{{ $item['product'] }}</td>
                    <td style="padding: 15px;">
                        @php
                            if($item['current_stock'] === 0) {
                                $stockClass = 'stock-zero';
                            } elseif($item['current_stock'] < $item['min_threshold']) {
                                $stockClass = 'stock-low';
                            } else {
                                $stockClass = 'stock-sufficient';
                            }
                        @endphp
                        <span class="{{ $stockClass }}">
                            {{ $item['current_stock'] }} units
                        </span>
                    </td>
                    <td style="padding: 15px;">{{ $item['min_threshold'] }} units</td>
                    <td style="padding: 15px;">₱{{ number_format($item['unit_price']) }}</td>
                    <td style="padding: 15px;">
                        @php
                            if($item['status'] === 'Good') {
                                $statusClass = 'status-good';
                            } elseif($item['status'] === 'Low Stock') {
                                $statusClass = 'status-low';
                            } else {
                                $statusClass = 'status-out';
                            }
                        @endphp
                        <span class="{{ $statusClass }}">
                            {{ $item['status'] }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        <button class="btn-update" data-id="{{ $item['id'] }}" data-product="{{ $item['product'] }}" data-current-stock="{{ $item['current_stock'] }}">
                            Update
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Summary Stats -->
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-top: 30px;">
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
            <p style="margin: 0 0 10px 0; color: #666; font-size: 0.9rem;">Total Products</p>
            <p style="margin: 0; font-size: 2rem; font-weight: bold; color: #d32f2f;">{{ count($inventory) }}</p>
        </div>
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
            <p style="margin: 0 0 10px 0; color: #666; font-size: 0.9rem;">Low/Out of Stock</p>
            <p style="margin: 0; font-size: 2rem; font-weight: bold; color: #ff9800;">{{ count(array_filter($inventory, fn($i) => $i['status'] !== 'Good')) }}</p>
        </div>
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
            <p style="margin: 0 0 10px 0; color: #666; font-size: 0.9rem;">Total Stock Value</p>
            <p style="margin: 0; font-size: 2rem; font-weight: bold; color: #4caf50;">
                ₱{{ number_format(array_sum(array_map(fn($i) => $i['current_stock'] * $i['unit_price'], $inventory))) }}
            </p>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div id="updateModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; padding: 30px; width: 90%; max-width: 400px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
        <h3 id="modalTitle" style="margin-top: 0; color: #d32f2f;">Update Inventory</h3>
        <form id="updateForm" method="POST" action="">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Current Quantity</label>
                <input type="number" id="currentQty" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background: #f9f9f9;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">New Quantity</label>
                <input type="number" name="quantity" id="newQty" required min="0" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="flex: 1; background-color: #d32f2f; color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 1rem;">
                    Update Stock
                </button>
                <button type="button" onclick="closeUpdateModal()" style="flex: 1; background-color: #f0f0f0; color: #333; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 1rem;">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openUpdateModal(id, product, currentQty) {
    const modal = document.getElementById('updateModal');
    const form = document.getElementById('updateForm');
    const title = document.getElementById('modalTitle');
    const currentQtyInput = document.getElementById('currentQty');
    const newQtyInput = document.getElementById('newQty');

    title.textContent = 'Update: ' + product;
    currentQtyInput.value = currentQty;
    newQtyInput.value = '';
    form.action = '/supplier/inventory/' + id;

    modal.style.display = 'flex';
}

function closeUpdateModal() {
    document.getElementById('updateModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-update').forEach(function(button) {
        button.addEventListener('click', function() {
            openUpdateModal(button.dataset.id, button.dataset.product, Number(button.dataset.currentStock));
        });
    });
});

window.onclick = function(event) {
    const modal = document.getElementById('updateModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>

@endsection
