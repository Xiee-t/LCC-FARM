
@extends('layouts.app')

@section('content')
@include('components.dashboard_navbar')

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #333; margin-bottom: 20px;">Profile</h1>

    <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; max-width: 600px;">
        <h3>Supplier Information</h3>
        <p><strong>Name:</strong> LCC Farms</p>
        <p><strong>Email:</strong> supplier@gmail.com</p>
        <p><strong>Status:</strong> <span style="color: #4CAF50;">Active</span></p>
        <p><strong>Total Products:</strong> 5</p>
        <p><strong>Average Rating:</strong> 4.5</p>
    </div>
</div>
@endsection

