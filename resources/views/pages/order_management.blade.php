@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="font-size: 1.8rem; color: #d32f2f; margin: 0;">Incoming Orders</h2>
        <a href="{{ route('supplier-dashboard') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">← Back to Dashboard</a>
    </div>

    <!-- Filter Section -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
            <div>
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Search Orders</label>
                <input type="text" placeholder="Search by Order ID..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Filter by Status</label>
                <select style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <option>All Orders</option>
                    <option>Pending</option>
                    <option>In Progress</option>
                    <option>Completed</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">&nbsp;</label>
                <button style="width: 100%; background-color: #d32f2f; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                    Apply Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Orders Grid -->
    <div style="display: grid; gap: 20px;">
        @foreach($orders as $order)
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; border-left: 4px solid #d32f2f;">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 15px; align-items: center; margin-bottom: 15px;">
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Order ID</p>
                    <p style="margin: 0; font-weight: bold; font-size: 1.1rem;">{{ $order['order_id'] }}</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Product</p>
                    <p style="margin: 0; font-weight: bold;">{{ $order['product'] }}</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Quantity</p>
                    <p style="margin: 0; font-weight: bold;">{{ $order['quantity'] }} Trays</p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Status</p>
                    <span class="status-chip">{{ $order['status'] }}</span>
                </div>
                <button class="status-btn" data-order-id="{{ $order['id'] }}" data-order-label="{{ $order['order_id'] }}" data-order-status="{{ $order['status'] }}" 
                    style="background-color: #d32f2f; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 0.9rem; white-space: nowrap;">
                    Update Status
                </button>
            </div>

            <!-- Order Details -->
            <div style="background: #f9f9f9; padding: 15px; border-radius: 4px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                <div>
                    <p style="margin: 0 0 5px 0; color: #666; font-size: 0.9rem;">Customer</p>
                    <p style="margin: 0; font-weight: bold;">{{ $order['customer'] }}</p>
                </div>
                <div>
                    <p style="margin: 0 0 5px 0; color: #666; font-size: 0.9rem;">Order Date</p>
                    <p style="margin: 0; font-weight: bold;">{{ $order['order_date'] }}</p>
                </div>
                <div>
                    <p style="margin: 0 0 5px 0; color: #666; font-size: 0.9rem;">Expected Delivery</p>
                    <p style="margin: 0; font-weight: bold;">{{ $order['expected_delivery'] }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Order Stats -->
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px; margin-top: 30px;">
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
            <p style="margin: 0 0 10px 0; color: #666; font-size: 0.9rem;">Total Orders</p>
            <p style="margin: 0; font-size: 2rem; font-weight: bold; color: #d32f2f;">{{ count($orders) }}</p>
        </div>
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
            <p style="margin: 0 0 10px 0; color: #666; font-size: 0.9rem;">Pending</p>
            <p style="margin: 0; font-size: 2rem; font-weight: bold; color: #ff9800;">{{ count(array_filter($orders, fn($o) => $o['status'] === 'Pending')) }}</p>
        </div>
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
            <p style="margin: 0 0 10px 0; color: #666; font-size: 0.9rem;">In Progress</p>
            <p style="margin: 0; font-size: 2rem; font-weight: bold; color: #2196f3;">{{ count(array_filter($orders, fn($o) => $o['status'] === 'In Progress')) }}</p>
        </div>
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
            <p style="margin: 0 0 10px 0; color: #666; font-size: 0.9rem;">Completed</p>
            <p style="margin: 0; font-size: 2rem; font-weight: bold; color: #4caf50;">{{ count(array_filter($orders, fn($o) => $o['status'] === 'Completed')) }}</p>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; padding: 30px; width: 90%; max-width: 450px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
        <h3 id="statusModalTitle" style="margin-top: 0; color: #d32f2f;">Update Order Status</h3>
        <form id="statusForm" method="POST" action="">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">Current Status</label>
                <input type="text" id="currentStatus" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; background: #f9f9f9;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #333; font-weight: bold;">New Status</label>
                <select name="status" id="newStatus" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box;">
                    <option value="">-- Select Status --</option>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <div style="background: #f0f0f0; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                <p style="margin: 0 0 10px 0; color: #666; font-size: 0.9rem;">Status Flow:</p>
                <p style="margin: 0; font-size: 0.85rem; color: #666;">Pending → In Progress → Completed</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="flex: 1; background-color: #d32f2f; color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 1rem;">
                    Update Status
                </button>
                <button type="button" onclick="closeStatusModal()" style="flex: 1; background-color: #f0f0f0; color: #333; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 1rem;">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openStatusModal(id, orderId, currentStatus) {
    const modal = document.getElementById('statusModal');
    const form = document.getElementById('statusForm');
    const title = document.getElementById('statusModalTitle');
    const currentStatusInput = document.getElementById('currentStatus');
    const newStatusSelect = document.getElementById('newStatus');

    title.textContent = 'Update Status: ' + orderId;
    currentStatusInput.value = currentStatus;
    newStatusSelect.value = '';
    form.action = '/supplier/orders/' + id;

    modal.style.display = 'flex';
}

function closeStatusModal() {
    document.getElementById('statusModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.status-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            openStatusModal(button.dataset.orderId, button.dataset.orderLabel, button.dataset.orderStatus);
        });
    });
});

window.onclick = function(event) {
    const modal = document.getElementById('statusModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>

@endsection
