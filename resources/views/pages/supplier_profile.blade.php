@extends('layouts.app')

@section('content')
@include('components.distributor_theme')
@include('components.dashboard_navbar')

<div class="dist-page">
    <div class="dist-shell" style="max-width: 940px; padding-bottom: 28px;">
        <section class="dist-hero">
            <div class="dist-hero-head">
                <div>
                    <h1>Supplier Profile</h1>
                    <p>Review your supplier account details, business information, and current activity snapshot.</p>
                </div>
                <a href="{{ route('supplier-dashboard') }}" class="dist-back-link">Back to Dashboard</a>
            </div>
        </section>

        <section class="dist-card dist-card-padded" style="margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 18px; margin-bottom: 22px; flex-wrap: wrap;">
                <div style="width: 82px; height: 82px; background: linear-gradient(145deg, var(--dist-hero-start), var(--dist-hero-end)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2rem; font-weight: 800;">
                    {{ strtoupper(substr($profile['name'] ?? 'S', 0, 1)) }}
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
                @if(!empty($profile['contact_person']))
                    <div>
                        <p class="dist-muted" style="margin: 0 0 4px 0; font-size: 0.85rem;">Contact Person</p>
                        <p style="margin: 0; font-weight: 700;">{{ $profile['contact_person'] }}</p>
                    </div>
                @endif
            </div>
        </section>

        <div class="dist-metrics-grid">
            <div class="dist-metric-card">
                <h4>Total Products</h4>
                <p class="dist-metric-value">{{ $profile['total_products'] }}</p>
            </div>
            <div class="dist-metric-card">
                <h4>Completed Orders</h4>
                <p class="dist-metric-value" style="color: #2e7d32;">{{ $profile['completed_orders'] }}</p>
            </div>
        </div>

        <section class="dist-card dist-card-padded">
            <div style="display: grid; grid-template-columns: repeat(2, minmax(220px, 1fr)); gap: 10px; align-items: center;">
                <button onclick="editProfile()" class="dist-pill-btn dist-pill-btn-primary" type="button">Edit Profile</button>
                <button onclick="changePassword()" class="dist-pill-btn dist-pill-btn-neutral" type="button">Change Password</button>
            </div>
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
