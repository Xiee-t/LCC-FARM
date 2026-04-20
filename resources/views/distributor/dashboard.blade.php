@extends('distributor_theme') 

@section('content')
    <div class="container">
        <h1>Distributor Dashboard</h1>
        <p>Welcome to the distributor control panel.</p>
        
        {{-- You can include your inventory alerts component here if needed --}}
        @include('inventory_alerts') 
    </div>
@endsection