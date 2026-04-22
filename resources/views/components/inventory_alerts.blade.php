<style>
    .alert-box { padding: 15px; border-radius: 4px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid #d32f2f; background: white; color: #d32f2f; }
    .alert-low, .alert-out { background: white; color: #d32f2f; }
    .alert-text-low, .alert-text-out { color: #d32f2f; }
    .alert-btn-low, .alert-btn-out { background-color: #d32f2f; }
    .alert-box p { margin: 0; font-weight: bold; }
    .alert-box p:last-child { margin: 5px 0 0 0; font-size: 0.9rem; font-weight: normal; }
    .alert-btn { color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold; white-space: nowrap; margin-left: 10px; display: inline-block; border: 1px solid #d32f2f; background-color: #d32f2f; }
    .alert-good { background: white; border-left: 4px solid #d32f2f; padding: 15px; border-radius: 4px; color: #d32f2f; }
</style>

<div>
    @if(count($alerts) > 0)
        @foreach($alerts as $alert)
            @php $isLowStock = $alert['status'] === 'Low Stock'; @endphp
            <div class="alert-box {{ $isLowStock ? 'alert-low' : 'alert-out' }}">
                <div>
                    <p class="{{ $isLowStock ? 'alert-text-low' : 'alert-text-out' }}">⚠ {{ $alert['product'] }}</p>
                    <p class="{{ $isLowStock ? 'alert-text-low' : 'alert-text-out' }}">{{ $alert['status'] }}: {{ $alert['stock'] }} units remaining</p>
                </div>
                <a href="{{ route('supplier-inventory') }}" class="alert-btn {{ $isLowStock ? 'alert-btn-low' : 'alert-btn-out' }}">Reorder</a>
            </div>
        @endforeach
    @else
        <div class="alert-good">✓ All inventory levels are good!</div>
    @endif
</div>
