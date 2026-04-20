@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1200px; margin: 0 auto; padding: 20px; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="margin: 0 0 4px 0; color: #333; font-size: 1.6rem; font-weight: 600;">Manage Suppliers</h1>
            <p style="margin: 0; color: #666; font-size: 0.95rem;">View and manage your supplier partnerships</p>
        </div>
        <a href="{{ route('distributor-dashboard') }}" style="color: #d32f2f; text-decoration: none; font-size: 0.9rem; font-weight: 600;">← Back to Dashboard</a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        @foreach($suppliers as $supplier)
            <div style="background: white; border-radius: 8px; padding: 20px; border: 1px solid #e0e0e0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: all 0.2s ease;">
                <h3 style="margin: 0 0 12px 0; color: #333; font-size: 1.05rem; font-weight: 600;">{{ $supplier['name'] }}</h3>
                <div style="display: grid; gap: 10px; margin-bottom: 15px; font-size: 0.9rem;">
                    <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #666;">Products</span>
                        <span style="color: #333; font-weight: 600;">{{ $supplier['products'] }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                        <span style="color: #666;">Rating</span>
                        <span style="color: #333; font-weight: 600;">{{ $supplier['rating'] }}/5.0</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                        <span style="color: #666;">Status</span>
                        <span style="background: #2e7d32; color: white; padding: 3px 8px; border-radius: 3px; font-weight: 600; font-size: 0.8rem;">{{ $supplier['status'] }}</span>
                    </div>
                </div>
                <a href="#" style="display: block; width: 100%; padding: 10px; background: #d32f2f; color: white; border-radius: 6px; text-decoration: none; text-align: center; font-weight: 600; font-size: 0.9rem;">Contact Supplier</a>
            </div>
        @endforeach
    </div>
</div>

@include('components.footer')