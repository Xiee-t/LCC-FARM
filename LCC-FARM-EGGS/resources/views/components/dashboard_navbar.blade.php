<nav style="background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 15px 0; margin-bottom: 30px;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
        <h1 style="color: #d32f2f; font-size: 1.5rem; font-weight: bold; margin: 0;">LCC FARM EGGS</h1>
        
        <div style="display: flex; gap: 30px; align-items: center;">
            <a href="{{ route('dashboard') }}" style="color: #666; text-decoration: none; font-size: 0.95rem;">Home</a>
            <a href="{{ route('place-order') }}" style="color: #666; text-decoration: none; font-size: 0.95rem;">Place Order</a>
            <a href="{{ route('my-orders') }}" style="color: #666; text-decoration: none; font-size: 0.95rem;">My Orders</a>
            <a href="{{ route('order-history') }}" style="color: #666; text-decoration: none; font-size: 0.95rem;">History</a>
            <a href="{{ route('profile') }}" style="color: #666; text-decoration: none; font-size: 0.95rem;">Profile</a>
            <a href="{{ route('logout') }}" style="background-color: #d32f2f; color: white; padding: 10px 15px; border-radius: 4px; text-decoration: none; font-size: 0.95rem;">Logout</a>
        </div>
    </div>
</nav>