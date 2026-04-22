@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

@php
    $minimumDeliveryDate = now()->addDays(2)->toDateString();
@endphp

<div class="dist-page">
    <div class="dist-shell" style="max-width: 980px; padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Create New Order</h1>
                    <p>Select a product, set your quantity, and review the live total before checkout.</p>
                </div>
                <a href="{{ route('my-orders') }}" class="dist-back-link">My Orders</a>
            </div>
        </section>

        @if ($errors->any())
            <div class="dist-subtle-banner" style="background: #fef2f2; border-color: #fecaca; color: #dc2626;">
                <strong>Please fix the following:</strong>
                <ul style="margin: 8px 0 0 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="dist-card dist-card-padded">
            <form action="{{ route('order-confirm') }}" method="POST">
                @csrf

                <div style="margin-bottom: 22px;">
                    <label style="display: block; font-weight: 700; color: #7b2117; margin-bottom: 12px;">Select Egg Type</label>
                    <div class="dist-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                        @foreach (($products ?? []) as $product)
                            <label class="dist-card dist-card-padded" style="cursor: pointer; box-shadow: none;">
                                <div style="display: flex; align-items: flex-start; gap: 10px;">
                                    <input type="radio" name="egg_size" value="{{ $product['id'] }}" required style="margin-top: 6px;" {{ old('egg_size', $prefill['egg_size'] ?? null) == $product['id'] ? 'checked' : '' }}>
                                    <div>
                                        <h4 style="margin: 0 0 6px;">{{ $product['name'] }}</h4>
                                        <p class="dist-muted" style="margin: 0;">PHP {{ number_format($product['price'], 2) }}/tray</p>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div style="display: grid; gap: 18px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-weight: 700; color: #7b2117; margin-bottom: 8px;">Quantity (Trays)</label>
                        <input type="number" name="quantity" min="1" value="{{ old('quantity', $prefill['quantity'] ?? 1) }}" class="dist-order-input" style="width: 100%;" required>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 700; color: #7b2117; margin-bottom: 8px;">Delivery Address</label>
                        <input type="text" name="address" placeholder="Street address" value="{{ old('address', $prefill['address'] ?? '') }}" class="dist-order-input" style="width: 100%; margin-bottom: 10px;" required>
                        <div class="dist-order-address-row">
                            <input type="text" name="city" placeholder="City" value="{{ old('city', $prefill['city'] ?? '') }}" class="dist-order-input" style="width: 100%;" required>
                            <input type="text" name="postal_code" placeholder="Postal Code" value="{{ old('postal_code', $prefill['postal_code'] ?? '') }}" class="dist-order-input" style="width: 100%;" required>
                        </div>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 700; color: #7b2117; margin-bottom: 8px;">Preferred Delivery Date</label>
                        <input type="hidden" name="delivery_date" id="delivery_date" value="{{ old('delivery_date', $prefill['delivery_date'] ?? '') }}" required>
                        <div class="dist-date-picker">
                            <button type="button" id="deliveryDateTrigger" class="dist-date-trigger" aria-expanded="false" aria-controls="deliveryDatePopover">
                                <span id="deliveryDateLabel">Select a delivery date</span>
                                <span class="dist-date-trigger-icon" aria-hidden="true">▾</span>
                            </button>
                            <div id="deliveryDatePopover" class="dist-date-popover" hidden>
                                <div class="dist-date-header">
                                    <button type="button" id="deliveryPrevMonth" class="dist-date-nav" aria-label="Previous month">‹</button>
                                    <div id="deliveryMonthLabel" class="dist-date-month"></div>
                                    <button type="button" id="deliveryNextMonth" class="dist-date-nav" aria-label="Next month">›</button>
                                </div>
                                <div class="dist-date-weekdays">
                                    <span>Su</span>
                                    <span>Mo</span>
                                    <span>Tu</span>
                                    <span>We</span>
                                    <span>Th</span>
                                    <span>Fr</span>
                                    <span>Sa</span>
                                </div>
                                <div id="deliveryDateGrid" class="dist-date-grid"></div>
                            </div>
                        </div>
                        <p class="dist-muted" style="margin: 8px 0 0; font-size: 0.85rem;">Earliest available delivery date is 2 days from today.</p>
                    </div>
                </div>

                <section class="dist-card dist-card-padded" style="box-shadow: none; background: #fbf7f4; margin-bottom: 20px;">
                    <h3 class="dist-section-title">Order Summary</h3>
                    <div style="display: grid; gap: 10px;">
                        <div style="display: flex; justify-content: space-between;">
                            <span class="dist-muted">Estimated subtotal</span>
                            <strong id="subtotal">PHP 0.00</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span class="dist-muted">Delivery fee</span>
                            <strong>PHP 50.00</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 10px; border-top: 1px solid #eadfd8;">
                            <span style="font-weight: 700;">Total</span>
                            <strong id="total">PHP 50.00</strong>
                        </div>
                    </div>
                </section>

                <button type="submit" class="dist-pill-btn dist-pill-btn-primary" style="width: 100%; padding-block: 14px;">Review Order</button>
            </form>
        </section>
    </div>
    @include('components.footer')
</div>

<style>
    .dist-order-input {
        padding: 12px 14px;
        border: 1px solid #dfd4ce;
        border-radius: 12px;
        background: #fff;
        font: inherit;
        box-sizing: border-box;
    }

    .dist-order-address-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 160px;
        gap: 12px;
        align-items: start;
    }

    .dist-date-picker {
        position: relative;
    }

    .dist-date-trigger {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #dfd4ce;
        border-radius: 12px;
        background: #fff;
        font: inherit;
        color: #2f2f2f;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        box-sizing: border-box;
    }

    .dist-date-trigger-icon {
        color: #7b2117;
        font-size: 0.95rem;
    }

    .dist-date-popover {
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        z-index: 20;
        width: 320px;
        max-width: 100%;
        background: #fff;
        border: 1px solid #eadfd8;
        border-radius: 16px;
        box-shadow: 0 18px 36px rgba(29, 33, 28, 0.14);
        padding: 14px;
    }

    .dist-date-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .dist-date-month {
        font-weight: 800;
        color: #7b2117;
    }

    .dist-date-nav {
        width: 34px;
        height: 34px;
        border: 1px solid #eadfd8;
        border-radius: 999px;
        background: #fff7f2;
        color: #7b2117;
        font-size: 1rem;
        cursor: pointer;
    }

    .dist-date-weekdays,
    .dist-date-grid {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        gap: 6px;
    }

    .dist-date-weekdays {
        margin-bottom: 8px;
        color: #8b7e78;
        font-size: 0.78rem;
        text-align: center;
    }

    .dist-date-day {
        aspect-ratio: 1;
        border: 1px solid transparent;
        border-radius: 10px;
        background: #fff;
        color: #3a332f;
        font: inherit;
        cursor: pointer;
    }

    .dist-date-day:hover:not(:disabled) {
        border-color: #e7d2ca;
        background: #fff7f2;
    }

    .dist-date-day.is-selected {
        background: var(--dist-primary);
        color: #fff;
        font-weight: 700;
        box-shadow: 0 8px 18px rgba(178, 53, 42, 0.24);
    }

    .dist-date-day:disabled,
    .dist-date-day.is-empty {
        color: #c8beb8;
        cursor: not-allowed;
        background: #faf7f5;
    }

    @media (max-width: 680px) {
        .dist-order-address-row {
            grid-template-columns: 1fr;
        }

        .dist-date-popover {
            width: 100%;
        }
    }
</style>

<script>
    const sizeMap = {
        @foreach (($products ?? []) as $product)
            "{{ $product['id'] }}": {{ $product['price'] }},
        @endforeach
    };
    const minimumDeliveryDate = "{{ $minimumDeliveryDate }}";
    const deliveryDateInput = document.getElementById('delivery_date');
    const deliveryDateTrigger = document.getElementById('deliveryDateTrigger');
    const deliveryDateLabel = document.getElementById('deliveryDateLabel');
    const deliveryDatePopover = document.getElementById('deliveryDatePopover');
    const deliveryMonthLabel = document.getElementById('deliveryMonthLabel');
    const deliveryDateGrid = document.getElementById('deliveryDateGrid');
    const deliveryPrevMonth = document.getElementById('deliveryPrevMonth');
    const deliveryNextMonth = document.getElementById('deliveryNextMonth');

    const minimumDate = new Date(minimumDeliveryDate + 'T00:00:00');
    let calendarMonth = new Date(minimumDate.getFullYear(), minimumDate.getMonth(), 1);
    let selectedDate = deliveryDateInput.value ? new Date(deliveryDateInput.value + 'T00:00:00') : null;

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

    function formatDateLabel(date) {
        return date.toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });
    }

    function toIsoDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function syncDateLabel() {
        deliveryDateLabel.textContent = selectedDate ? formatDateLabel(selectedDate) : 'Select a delivery date';
    }

    function sameDate(a, b) {
        return a && b
            && a.getFullYear() === b.getFullYear()
            && a.getMonth() === b.getMonth()
            && a.getDate() === b.getDate();
    }

    function renderCalendar() {
        deliveryMonthLabel.textContent = calendarMonth.toLocaleDateString('en-US', {
            month: 'long',
            year: 'numeric'
        });

        deliveryDateGrid.innerHTML = '';

        const year = calendarMonth.getFullYear();
        const month = calendarMonth.getMonth();
        const firstDayIndex = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDayIndex; i++) {
            const spacer = document.createElement('button');
            spacer.type = 'button';
            spacer.className = 'dist-date-day is-empty';
            spacer.disabled = true;
            deliveryDateGrid.appendChild(spacer);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const candidate = new Date(year, month, day);
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'dist-date-day';
            button.textContent = day;

            if (candidate < minimumDate) {
                button.disabled = true;
            } else {
                button.addEventListener('click', () => {
                    selectedDate = candidate;
                    deliveryDateInput.value = toIsoDate(candidate);
                    syncDateLabel();
                    renderCalendar();
                    deliveryDatePopover.hidden = true;
                    deliveryDateTrigger.setAttribute('aria-expanded', 'false');
                });
            }

            if (sameDate(candidate, selectedDate)) {
                button.classList.add('is-selected');
            }

            deliveryDateGrid.appendChild(button);
        }
    }

    deliveryDateTrigger.addEventListener('click', () => {
        const isHidden = deliveryDatePopover.hidden;
        deliveryDatePopover.hidden = !isHidden;
        deliveryDateTrigger.setAttribute('aria-expanded', String(isHidden));
    });

    deliveryPrevMonth.addEventListener('click', () => {
        const previousMonth = new Date(calendarMonth.getFullYear(), calendarMonth.getMonth() - 1, 1);
        if (previousMonth >= new Date(minimumDate.getFullYear(), minimumDate.getMonth(), 1)) {
            calendarMonth = previousMonth;
            renderCalendar();
        }
    });

    deliveryNextMonth.addEventListener('click', () => {
        calendarMonth = new Date(calendarMonth.getFullYear(), calendarMonth.getMonth() + 1, 1);
        renderCalendar();
    });

    document.addEventListener('click', (event) => {
        if (!event.target.closest('.dist-date-picker')) {
            deliveryDatePopover.hidden = true;
            deliveryDateTrigger.setAttribute('aria-expanded', 'false');
        }
    });

    document.querySelector('form').addEventListener('change', updateTotals);
    document.querySelector('input[name="quantity"]').addEventListener('input', updateTotals);
    syncDateLabel();
    renderCalendar();
    updateTotals();
</script>
@endsection
