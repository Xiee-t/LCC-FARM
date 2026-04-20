<nav style="background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 15px 0; margin-bottom: 30px; border-bottom: 4px solid #d32f2f;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: #d32f2f; font-size: 1.5rem; font-weight: bold; margin: 0;">LCC FARM EGGS</h1>
            @if(request()->routeIs('supplier-*'))
                <small style="color: #d32f2f; font-weight: bold;">Supplier Dashboard</small>
            @elseif(request()->routeIs('distributor-*'))
                <small style="color: #d32f2f; font-weight: bold;">Distributor Dashboard</small>
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
            @elseif(request()->routeIs('distributor-*'))
                <a href="{{ route('distributor-dashboard') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Dashboard</a>
                <a href="{{ route('distributor-available-orders') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Order from Supplier</a>
                <a href="{{ route('distributor-track-orders') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Track Orders</a>
                <a href="{{ route('distributor-manage-suppliers') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Manage Suppliers</a>
                <a href="{{ route('distributor-profile') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Profile</a>
            @else
                <a href="{{ route('dashboard') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Home</a>
                <a href="{{ route('place-order') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Place Order</a>
                <a href="{{ route('my-orders') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">My Orders</a>
                <a href="{{ route('order-history') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">History</a>
                <a href="{{ route('buyer-profile') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.95rem;">Profile</a>
            @endif
            <a href="{{ route('logout') }}" style="background-color: #d32f2f; color: white; padding: 10px 15px; border-radius: 4px; text-decoration: none; font-size: 0.95rem;">Logout</a>
        </div>
    </div>
</nav>