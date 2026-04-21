@if(request()->routeIs('distributor-*'))
    <nav class="dist-distributor-nav">
        <div class="dist-nav-inner">
            <div class="dist-brand">
                <div class="dist-brand-logo">LCC</div>
                <div>
                    <h2>LCC FARM EGGS</h2>
                    <small>Distributor Dashboard</small>
                </div>
            </div>

            <div class="dist-nav-links">
                <a href="{{ route('distributor-dashboard') }}" class="dist-nav-link {{ request()->routeIs('distributor-dashboard') ? 'is-active' : '' }}">Dashboard</a>
                <a href="{{ route('distributor-available-orders') }}" class="dist-nav-link {{ request()->routeIs('distributor-available-orders') ? 'is-active' : '' }}">Order from Supplier</a>
                <a href="{{ route('distributor-track-orders') }}" class="dist-nav-link {{ request()->routeIs('distributor-track-orders') || request()->routeIs('distributor-delivery-tracking') ? 'is-active' : '' }}">Track Orders</a>
                <a href="{{ route('distributor-manage-suppliers') }}" class="dist-nav-link {{ request()->routeIs('distributor-manage-suppliers') ? 'is-active' : '' }}">Manage Suppliers</a>
                <a href="{{ route('distributor-profile') }}" class="dist-nav-link {{ request()->routeIs('distributor-profile') ? 'is-active' : '' }}">Profile</a>
            </div>

            <a href="{{ route('logout') }}" class="dist-nav-logout">Logout</a>
        </div>
    </nav>
@else
    <nav style="background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 15px 0; margin-bottom: 30px; border-bottom: 4px solid #d32f2f;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="color: #d32f2f; font-size: 1.5rem; font-weight: bold; margin: 0;">LCC FARM EGGS</h1>
                @if(request()->routeIs('supplier-*'))
                    <small style="color: #d32f2f; font-weight: bold;">Supplier Dashboard</small>
                @else
                    <small style="color: #d32f2f; font-weight: bold;">Buyer Portal</small>
                @endif
            </div>

            <div style="display: flex; gap: 30px; align-items: center;">
                @if(request()->routeIs('supplier-*'))
                    <a href="{{ route('supplier-dashboard') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Dashboard</a>
                    <a href="{{ route('supplier-inventory') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Manage Inventory</a>
                    <a href="{{ route('supplier-orders') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">View Orders</a>
                    <a href="{{ route('supplier-profile') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Profile</a>
                @else
                    <a href="{{ route('dashboard') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Home</a>
                    <a href="{{ route('place-order') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Place Order</a>
                    <a href="{{ route('my-orders') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">My Orders</a>
                    <a href="{{ route('order-history') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">History</a>

                @endif
                <a href="{{ route('logout') }}" style="background-color: #d32f2f; color: white; padding: 10px 15px; border-radius: 4px; text-decoration: none; font-size: 0.95rem;">Logout</a>
            </div>
        </div>
    </nav>
@endif