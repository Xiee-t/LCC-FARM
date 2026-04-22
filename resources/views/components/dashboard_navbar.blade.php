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
    <nav class="dist-distributor-nav">
        <div class="dist-nav-inner">
            <div class="dist-brand">
                <div class="dist-brand-logo">LCC</div>
                <div>
                    <h2>LCC FARM EGGS</h2>
                    @if(request()->routeIs('supplier-*'))
                        <small>Supplier Dashboard</small>
                    @else
                        <small>Buyer Portal</small>
                    @endif
                </div>
            </div>

            <div class="dist-nav-links">
                @if(request()->routeIs('supplier-*'))
                    <a href="{{ route('supplier-dashboard') }}" class="dist-nav-link {{ request()->routeIs('supplier-dashboard') ? 'is-active' : '' }}">Dashboard</a>
                    <a href="{{ route('supplier-inventory') }}" class="dist-nav-link {{ request()->routeIs('supplier-inventory') ? 'is-active' : '' }}">Inventory</a>
                    <a href="{{ route('supplier-orders') }}" class="dist-nav-link {{ request()->routeIs('supplier-orders') ? 'is-active' : '' }}">Orders</a>
                    <a href="{{ route('supplier-profile') }}" class="dist-nav-link {{ request()->routeIs('supplier-profile') ? 'is-active' : '' }}">Profile</a>
                @else
                    <a href="{{ route('buyer-dashboard') }}" class="dist-nav-link {{ request()->routeIs('buyer-dashboard') ? 'is-active' : '' }}">Dashboard</a>
                    <a href="{{ route('place-order') }}" class="dist-nav-link {{ request()->routeIs('place-order') ? 'is-active' : '' }}">Place Order</a>
                    <a href="{{ route('my-orders') }}" class="dist-nav-link {{ request()->routeIs('my-orders') ? 'is-active' : '' }}">My Orders</a>
                    <a href="{{ route('order-history') }}" class="dist-nav-link {{ request()->routeIs('order-history') ? 'is-active' : '' }}">History</a>
                    <a href="{{ route('profile') }}" class="dist-nav-link {{ request()->routeIs('profile') || request()->routeIs('buyer-profile') ? 'is-active' : '' }}">Profile</a>
                @endif
            </div>

            <a href="{{ route('logout') }}" class="dist-nav-logout">Logout</a>
        </div>
    </nav>
@endif
