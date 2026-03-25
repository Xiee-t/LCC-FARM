@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div style="width: 100%; max-width: 500px; padding: 0 20px;">
        <!-- Navigation Buttons -->
        <div style="text-align: center; margin-bottom: 40px;">
            <a href="{{ route('login') }}" style="color: #d32f2f; text-decoration: none; font-size: 1rem; margin-right: 20px; display: inline-block; border-bottom: 2px solid #d32f2f; padding-bottom: 5px;">Login</a>
            <a href="{{ route('signup') }}" style="color: #666; text-decoration: none; font-size: 1rem; display: inline-block;">Sign Up</a>
        </div>

        <!-- Branding -->
        <div style="text-align: center; margin-bottom: 50px;">
            <h1 style="color: #d32f2f; font-size: 1.8rem; font-weight: bold; margin: 0;">LCC FARM EGGS</h1>
        </div>

        <!-- Form Card -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 40px;">
            @if(session('success'))
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    @foreach($errors->all() as $error)
                        <p style="margin: 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <h2 style="text-align: center; color: #d32f2f; font-size: 1.5rem; font-weight: bold; margin-bottom: 30px;">Login</h2>
            
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div style="margin-bottom: 15px;">
                    <input type="text" name="phone" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;" placeholder="Enter Phone Number" required>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <input type="password" name="password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;" placeholder="Password" required>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <button type="submit" style="width: 100%; background-color: #d32f2f; color: white; padding: 12px; border-radius: 4px; font-size: 1rem; font-weight: bold; border: none; cursor: pointer;">Login</button>
                </div>
            </form>
            
            <p style="text-align: center; color: #d32f2f; font-size: 0.9rem; margin-bottom: 15px;">
                Login using Google or Facebook
            </p>
            
            <div style="display: flex; justify-content: center; gap: 15px; margin-bottom: 15px;">
                <a href="#" style="width: 50px; height: 50px; background-color: #d32f2f; display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none;">
                    <i class="fab fa-facebook-f" style="color: white; font-size: 1.5rem;"></i>
                </a>
                <a href="#" style="width: 50px; height: 50px; background-color: #d32f2f; display: flex; align-items: center; justify-content: center; border-radius: 50%; text-decoration: none;">
                    <i class="fab fa-google" style="color: white; font-size: 1.5rem;"></i>
                </a>
            </div>

            <p style="text-align: center; color: #666; font-size: 0.9rem; margin: 0;">
                Don't have an account? <a href="{{ route('signup') }}" style="color: #d32f2f; text-decoration: none;">Sign Up</a>
            </p>
        </div>
    </div>
</div>
@endsection
