@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

@php
    $lowStockCount = count(array_filter($inventory, fn($item) => $item['status'] !== 'Good'));
    $totalStockValue = array_sum(array_map(fn($item) => $item['current_stock'] * $item['unit_price'], $inventory));
@endphp

<div class="dist-page">
    <div class="dist-shell" style="padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Inventory Management</h1>
                    <p>Review stock levels, monitor thresholds, and update quantities before they impact incoming orders.</p>
                </div>
                <a href="{{ route('supplier-dashboard') }}" class="dist-back-link">Back to Dashboard</a>
            </div>
        </section>

        @if(session('success'))
            <div class="dist-subtle-banner" style="background: #e6f5e8; border-color: #c7e3cb; color: #1f5b22;">
                {{ session('success') }}
            </div>
        @endif

        <section class="dist-card dist-card-padded" style="margin-bottom: 24px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label class="dist-muted" style="display: block; margin-bottom: 8px; font-weight: 700;">Search Product</label>
                    <input type="text" placeholder="Search inventory..." class="supplier-input" id="inventorySearch">
                </div>
                <div>
                    <label class="dist-muted" style="display: block; margin-bottom: 8px; font-weight: 700;">Filter by Status</label>
                    <select class="supplier-input" id="inventoryStatusFilter">
                        <option value="All Items">All Items</option>
                        <option value="Good">Good</option>
                        <option value="Low Stock">Low Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
            </div>
        </section>

        <section class="dist-card dist-card-padded">
            <div style="display: flex; justify-content: space-between; gap: 16px; align-items: flex-start; flex-wrap: wrap; margin-bottom: 16px;">
                <div>
                    <h3 class="dist-section-title">Inventory Overview</h3>
                    <p class="dist-muted" style="margin: 0;">Current quantities, reorder thresholds, and price references for each egg product.</p>
                </div>
            </div>

            <div class="dist-table-wrap">
                <table class="dist-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Current Stock</th>
                            <th>Min. Threshold</th>
                            <th>Unit Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
                        @foreach($inventory as $item)
                            @php
                                $statusClass = match ($item['status']) {
                                    'Low Stock' => 'dist-status-pending',
                                    'Out of Stock' => 'supplier-status-out',
                                    default => 'dist-status-delivered',
                                };
                            @endphp
                            <tr data-product="{{ strtolower($item['product']) }}" data-status="{{ $item['status'] }}">
                                <td class="dist-order-id">{{ $item['product'] }}</td>
                                <td>{{ $item['current_stock'] }} units</td>
                                <td>{{ $item['min_threshold'] }} units</td>
                                <td>PHP {{ number_format($item['unit_price'], 2) }}</td>
                                <td>
                                    <span class="dist-status-chip {{ $statusClass }}">{{ $item['status'] }}</span>
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="dist-pill-btn dist-pill-btn-primary supplier-update-btn"
                                        data-id="{{ $item['id'] }}"
                                        data-product="{{ $item['product'] }}"
                                        data-current-stock="{{ $item['current_stock'] }}">
                                        Update
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        <tr id="inventoryEmptyState" style="display: none;">
                            <td colspan="6" style="text-align: center; color: #7d746f;">No inventory items match the current filters.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="dist-metrics-grid" style="margin-top: 24px;">
            <div class="dist-metric-card">
                <h4>Total Products</h4>
                <p class="dist-metric-value">{{ count($inventory) }}</p>
            </div>
            <div class="dist-metric-card">
                <h4>Low/Out of Stock</h4>
                <p class="dist-metric-value" style="color: #d18a00;">{{ $lowStockCount }}</p>
            </div>
            <div class="dist-metric-card">
                <h4>Total Stock Value</h4>
                <p class="dist-metric-value" style="color: #2e7d32;">PHP {{ number_format($totalStockValue, 2) }}</p>
            </div>
        </div>
    </div>
    @include('components.footer')
</div>

<div id="updateModal" class="supplier-modal" style="display: none;">
    <div class="supplier-modal-card">
        <h3 id="modalTitle" style="margin-top: 0; color: #7b2117;">Update Inventory</h3>
        <form id="updateForm" method="POST" action="">
            @csrf
            <div style="margin-bottom: 18px;">
                <label class="dist-muted" style="display: block; margin-bottom: 8px; font-weight: 700;">Current Quantity</label>
                <input type="number" id="currentQty" readonly class="supplier-input" style="background: #f7f2ef;">
            </div>
            <div style="margin-bottom: 18px;">
                <label class="dist-muted" style="display: block; margin-bottom: 8px; font-weight: 700;">New Quantity</label>
                <input type="number" name="quantity" id="newQty" required min="0" class="supplier-input">
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="dist-pill-btn dist-pill-btn-primary" style="flex: 1;">Update Stock</button>
                <button type="button" onclick="closeUpdateModal()" class="dist-pill-btn dist-pill-btn-neutral" style="flex: 1;">Cancel</button>
            </div>
        </form>
    </div>
</div>

<style>
    .supplier-input {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #dfd4ce;
        border-radius: 12px;
        background: #fff;
        font: inherit;
        box-sizing: border-box;
    }

    .supplier-update-btn {
        min-width: 96px;
    }

    .supplier-status-out {
        background: #f4d8d8;
        color: #8d1d1d;
    }

    .supplier-modal {
        position: fixed;
        inset: 0;
        background: rgba(34, 25, 20, 0.42);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .supplier-modal-card {
        width: min(100%, 420px);
        background: #fff;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 24px 50px rgba(0, 0, 0, 0.2);
        border: 1px solid #efe7e2;
    }

    @media (max-width: 700px) {
        .dist-table {
            min-width: 760px;
        }
    }
</style>

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
    document.querySelectorAll('.supplier-update-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            openUpdateModal(button.dataset.id, button.dataset.product, Number(button.dataset.currentStock));
        });
    });

    const searchInput = document.getElementById('inventorySearch');
    const statusFilter = document.getElementById('inventoryStatusFilter');
    const rows = Array.from(document.querySelectorAll('#inventoryTableBody tr[data-product]'));
    const emptyState = document.getElementById('inventoryEmptyState');

    function applyInventoryFilters() {
        const searchTerm = (searchInput?.value || '').trim().toLowerCase();
        const selectedStatus = statusFilter?.value || 'All Items';
        let visibleCount = 0;

        rows.forEach(function(row) {
            const product = row.dataset.product || '';
            const status = row.dataset.status || '';
            const matchesSearch = searchTerm === '' || product.includes(searchTerm);
            const matchesStatus = selectedStatus === 'All Items' || status === selectedStatus;
            const shouldShow = matchesSearch && matchesStatus;

            row.style.display = shouldShow ? '' : 'none';
            if (shouldShow) {
                visibleCount += 1;
            }
        });

        emptyState.style.display = visibleCount === 0 ? '' : 'none';
    }

    searchInput?.addEventListener('input', applyInventoryFilters);
    statusFilter?.addEventListener('change', applyInventoryFilters);
    applyInventoryFilters();
});

window.onclick = function(event) {
    const modal = document.getElementById('updateModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>
@endsection
