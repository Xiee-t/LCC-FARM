@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

@php
    $isDistributor = request()->routeIs('distributor-profile');
    $isSupplier = request()->routeIs('supplier-profile');
    $isBuyer = !$isDistributor && !$isSupplier;
    $heroCopy = $isDistributor
        ? 'Review your distributor account details and delivery shortcuts.'
        : ($isSupplier
            ? 'Review your supplier account details and inventory shortcuts.'
            : 'Review your account details, active orders, and account shortcuts.');
@endphp

<div class="dist-page">
    <div class="dist-shell" style="max-width: 940px; padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>My Profile</h1>
                    <p>{{ $heroCopy }}</p>
                </div>
                <a href="{{ route($isDistributor ? 'distributor-dashboard' : ($isSupplier ? 'supplier-dashboard' : 'buyer-dashboard')) }}" class="dist-back-link">
                    Back to Dashboard
                </a>
            </div>
        </section>

        <section class="dist-card dist-card-padded" style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 18px; margin-bottom: 22px; flex-wrap: wrap;">
                <div style="width: 82px; height: 82px; background: linear-gradient(145deg, var(--dist-hero-start), var(--dist-hero-end)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2rem; font-weight: 800;">
                    {{ strtoupper(substr($profile['name'] ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <h3 style="margin: 0 0 4px 0;">{{ $profile['name'] }}</h3>
                    <p class="dist-muted" style="margin: 0; text-transform: capitalize;">{{ $profile['role'] }}</p>
                </div>
            </div>

            <div class="dist-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
                <div>
                    <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Email Address</p>
                    <p style="margin: 0; font-weight: 700;">{{ $profile['email'] }}</p>
                </div>
                <div>
                    <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Phone Number</p>
                    <p style="margin: 0; font-weight: 700;">{{ $profile['phone'] }}</p>
                </div>
                <div>
                    <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Account Type</p>
                    <p style="margin: 0; font-weight: 700; text-transform: capitalize;">{{ $profile['role'] }}</p>
                </div>
                <div>
                    <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Member Since</p>
                    <p style="margin: 0; font-weight: 700;">{{ $profile['member_since'] }}</p>
                </div>
                <div>
                    <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Account Status</p>
                    <span class="dist-status-chip dist-status-delivered">{{ $profile['status'] }}</span>
                </div>
                @if(!empty($profile['business_name']))
                    <div>
                        <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Business Name</p>
                        <p style="margin: 0; font-weight: 700;">{{ $profile['business_name'] }}</p>
                    </div>
                @endif
                @if(!empty($profile['business_address']))
                    <div>
                        <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Business Address</p>
                        <p style="margin: 0; font-weight: 700;">{{ $profile['business_address'] }}</p>
                    </div>
                @endif
                @if(!empty($profile['contact_person']) && !$isBuyer)
                    <div>
                        <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Contact Person</p>
                        <p style="margin: 0; font-weight: 700;">{{ $profile['contact_person'] }}</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="dist-card dist-card-padded">
            <h3 style="margin: 0 0 14px 0;">Quick Actions</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; margin-bottom: 18px;">
                <button onclick="editProfile()" class="dist-pill-btn dist-pill-btn-primary" type="button">Edit Profile</button>
                <button onclick="changePassword()" class="dist-pill-btn dist-pill-btn-neutral" type="button">Change Password</button>
            </div>

            <ul style="list-style: none; margin: 0; padding: 0;">
                @if($isDistributor)
                    <li style="padding: 10px 0; border-bottom: 1px solid #f0e8e2;"><a href="{{ route('distributor-available-orders') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">View Available Supplier Orders</a></li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #f0e8e2;"><a href="{{ route('distributor-track-orders') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">Track My Deliveries</a></li>
                    <li style="padding: 10px 0;"><a href="{{ route('distributor-manage-suppliers') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">Manage Suppliers</a></li>
                @elseif($isSupplier)
                    <li style="padding: 10px 0; border-bottom: 1px solid #f0e8e2;"><a href="{{ route('supplier-inventory') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">Manage Inventory</a></li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #f0e8e2;"><a href="{{ route('supplier-orders') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">View Supplier Orders</a></li>
                    <li style="padding: 10px 0;"><a href="{{ route('supplier-dashboard') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">Supplier Dashboard</a></li>
                @else
                    <li style="padding: 10px 0; border-bottom: 1px solid #f0e8e2;"><a href="{{ route('my-orders') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">View My Active Orders</a></li>
                    <li style="padding: 10px 0; border-bottom: 1px solid #f0e8e2;"><a href="{{ route('order-history') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">View Order History</a></li>
                    <li style="padding: 10px 0;"><a href="{{ route('place-order') }}" style="text-decoration: none; color: #7b2117; font-weight: 700;">Place New Order</a></li>
                @endif
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
</script>
@endsection
