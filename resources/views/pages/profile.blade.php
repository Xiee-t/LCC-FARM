@extends('layouts.app')

@section('content')
@if(request()->routeIs('distributor-profile'))
@include('components.distributor_theme')
@include('components.dashboard_navbar')

<div class="dist-page">
    <div class="dist-shell" style="max-width: 900px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h2>My Profile</h2>
                    <p>Review your distributor account details and quick actions.</p>
                </div>
                <a href="{{ route('distributor-dashboard') }}" class="dist-back-link">Back to Dashboard</a>
            </div>
        </section>

        <section class="dist-card dist-card-padded" style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 18px; flex-wrap: wrap;">
                <div style="width: 76px; height: 76px; background: linear-gradient(135deg, #b84934, #822418); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.8rem;">&#128100;</div>
                <div>
                    <h3 style="margin: 0 0 4px 0;">{{ session('user_identity') ?? 'John Doe' }}</h3>
                    <p class="dist-muted" style="margin: 0;">{{ session('user_registration')['email'] ?? 'john@example.com' }}</p>
                </div>
            </div>

            <div class="dist-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
                <div>
                    <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Phone Number</p>
                    <p style="margin: 0; font-weight: 700;">{{ session('user_registration')['phone'] ?? '+63 9XX XXX XXXX' }}</p>
                </div>
                <div>
                    <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Account Type</p>
                    <p style="margin: 0; font-weight: 700; text-transform: capitalize;">{{ session('user_role') ?? 'Buyer' }}</p>
                </div>
                <div>
                    <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Member Since</p>
                    <p style="margin: 0; font-weight: 700;">March 25, 2026</p>
                </div>
                <div>
                    <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Account Status</p>
                    <span class="dist-status-chip dist-status-delivered">Active &amp; Verified</span>
                </div>
            </div>
        </section>

        <section class="dist-card dist-card-padded" style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 12px 0;">Quick Actions</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                <button onclick="editProfile()" class="dist-pill-btn dist-pill-btn-primary" type="button">Edit Profile</button>
                <button onclick="changePassword()" class="dist-pill-btn dist-pill-btn-neutral" type="button">Change Password</button>
            </div>

            <ul style="list-style: none; margin: 0; padding: 0;">
                <li style="padding: 10px 0; border-bottom: 1px solid #f0e8e2;"><a href="{{ route('distributor-available-orders') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">View Available Supplier Orders</a></li>
                <li style="padding: 10px 0; border-bottom: 1px solid #f0e8e2;"><a href="{{ route('distributor-track-orders') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">Track My Deliveries</a></li>
                <li style="padding: 10px 0; border-bottom: 1px solid #f0e8e2;"><a href="{{ route('distributor-manage-suppliers') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">Manage Suppliers</a></li>
                <li style="padding: 10px 0;"><a onclick="deleteAccount()" style="text-decoration: none; color: #6a5e59; cursor: pointer; font-weight: 700;">Delete Account</a></li>
            </ul>
        </section>
    </div>
    @include('components.footer')
</div>

<script>
    function editProfile() {
        alert('Edit Profile feature coming soon!');
    }

    function changePassword() {
        alert('Change Password feature coming soon!');
    }

    function deleteAccount() {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            alert('Account deletion requested. Please confirm via email.');
        }
    }
</script>
@else
@include('components.dashboard_navbar')

<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2 style="font-size: 1.8rem; color: #d32f2f; margin-bottom: 30px;">My Profile</h2>

    <!-- Profile Card -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #d32f2f, #b71c1c); border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">👤</div>
        </div>

        <!-- Profile Info -->
        <div style="margin-bottom: 25px;">
            <label style="display: block; color: #666; font-size: 0.9rem; margin-bottom: 5px;">Full Name</label>
            <p style="margin: 0; font-size: 1.1rem; font-weight: 600;">{{ session('user_identity') ?? 'John Doe' }}</p>
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: block; color: #666; font-size: 0.9rem; margin-bottom: 5px;">Email Address</label>
            <p style="margin: 0; font-size: 1.1rem; font-weight: 600;">{{ session('user_registration')['email'] ?? 'john@example.com' }}</p>
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: block; color: #666; font-size: 0.9rem; margin-bottom: 5px;">Phone Number</label>
            <p style="margin: 0; font-size: 1.1rem; font-weight: 600;">{{ session('user_registration')['phone'] ?? '+63 9XX XXX XXXX' }}</p>
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: block; color: #666; font-size: 0.9rem; margin-bottom: 5px;">Account Type</label>
            <p style="margin: 0; font-size: 1.1rem; font-weight: 600; text-transform: capitalize;">{{ session('user_role') ?? 'Buyer' }}</p>
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: block; color: #666; font-size: 0.9rem; margin-bottom: 5px;">Member Since</label>
            <p style="margin: 0; font-size: 1.1rem; font-weight: 600;">March 25, 2026</p>
        </div>

        <div style="border-top: 1px solid #eee; padding-top: 20px;">
            <label style="display: block; color: #666; font-size: 0.9rem; margin-bottom: 10px;">Account Status</label>
            <p style="margin: 0; background-color: #4caf50; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem; display: inline-block; font-weight: 600;">✓ Active & Verified</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
        <button onclick="editProfile()" style="background-color: #d32f2f; color: white; padding: 12px 20px; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: 600;">Edit Profile</button>
        <button onclick="changePassword()" style="background-color: #666; color: white; padding: 12px 20px; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: 600;">Change Password</button>
    </div>

    <!-- Quick Actions Section -->
    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px;">
        <h3 style="color: #333; margin-top: 0; margin-bottom: 15px;">Quick Actions</h3>
        <ul style="list-style: none; padding: 0; margin: 0;">
            @if(session('user_role') === 'distributor')
                <li style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <a href="{{ route('distributor-available-orders') }}" style="color: #d32f2f; text-decoration: none; font-weight: 600;">→ View Available Supplier Orders</a>
                </li>
                <li style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <a href="{{ route('distributor-track-orders') }}" style="color: #d32f2f; text-decoration: none; font-weight: 600;">→ Track My Deliveries</a>
                </li>
                <li style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <a href="{{ route('distributor-manage-suppliers') }}" style="color: #d32f2f; text-decoration: none; font-weight: 600;">→ Manage Suppliers</a>
                </li>
            @elseif(session('user_role') === 'supplier')
                <li style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <a href="{{ route('supplier-inventory') }}" style="color: #d32f2f; text-decoration: none; font-weight: 600;">→ Manage Inventory</a>
                </li>
                <li style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <a href="{{ route('supplier-orders') }}" style="color: #d32f2f; text-decoration: none; font-weight: 600;">→ View Supplier Orders</a>
                </li>
            @else
                <li style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <a href="{{ route('my-orders') }}" style="color: #d32f2f; text-decoration: none; font-weight: 600;">→ View My Active Orders</a>
                </li>
                <li style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <a href="{{ route('order-history') }}" style="color: #d32f2f; text-decoration: none; font-weight: 600;">→ View Order History</a>
                </li>
                <li style="margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #eee;">
                    <a href="{{ route('place-order') }}" style="color: #d32f2f; text-decoration: none; font-weight: 600;">→ Place New Order</a>
                </li>
            @endif
            <li>
                <a onclick="deleteAccount()" style="color: #666; text-decoration: none; cursor: pointer; font-weight: 600;">→ Delete Account</a>
            </li>
        </ul>
    </div>
</div>

<script>
    function editProfile() {
        alert('Edit Profile feature coming soon!');
    }
    
    function changePassword() {
        alert('Change Password feature coming soon!');
    }
    
    function deleteAccount() {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            alert('Account deletion requested. Please confirm via email.');
        }
    }
</script>
@endif
@endsection