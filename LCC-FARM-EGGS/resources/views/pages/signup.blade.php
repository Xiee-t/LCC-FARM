@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div style="width: 100%; max-width: 500px; padding: 0 20px;">
        <!-- Navigation Buttons -->
        <div style="text-align: center; margin-bottom: 40px;">
            <a href="{{ route('login') }}" style="color: #666; text-decoration: none; font-size: 1rem; margin-right: 20px; display: inline-block;">Login</a>
            <a href="{{ route('signup') }}" style="color: #d32f2f; text-decoration: none; font-size: 1rem; display: inline-block; border-bottom: 2px solid #d32f2f; padding-bottom: 5px;">Sign Up</a>
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

            <h2 style="text-align: center; color: #d32f2f; font-size: 1.5rem; font-weight: bold; margin-bottom: 30px;">Sign Up</h2>
            
            <form method="POST" action="{{ route('signup.post') }}">
                @csrf
                <!-- Role Selection -->
                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #d32f2f; font-size: 0.95rem; font-weight: bold; margin-bottom: 10px;">Select Your Role</label>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <label style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer; transition: all 0.3s;">
                            <input type="radio" name="role" value="buyer" style="width: 18px; height: 18px; cursor: pointer;" required>
                            <span style="flex: 1;">
                                <strong>Buyer/User</strong><br>
                                <small style="color: #666;">Purchase eggs for retail</small>
                            </span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer; transition: all 0.3s;">
                            <input type="radio" name="role" value="distributor" style="width: 18px; height: 18px; cursor: pointer;" required>
                            <span style="flex: 1;">
                                <strong>Distributor</strong><br>
                                <small style="color: #666;">Distribute eggs wholesale</small>
                            </span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; padding: 12px; border: 1px solid #ddd; border-radius: 4px; cursor: pointer; transition: all 0.3s;">
                            <input type="radio" name="role" value="supplier" style="width: 18px; height: 18px; cursor: pointer;" required>
                            <span style="flex: 1;">
                                <strong>Supplier</strong><br>
                                <small style="color: #666;">Supply eggs in bulk</small>
                            </span>
                        </label>
                    </div>
                </div>

                <hr style="margin: 20px 0; border: none; border-top: 1px solid #eee;">

                <div style="margin-bottom: 15px;">
                    <input type="email" name="email" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;" placeholder="Email" required>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <input type="password" name="password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;" placeholder="Password*" required>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <input type="text" name="phone" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; box-sizing: border-box;" placeholder="Enter Phone Number" required>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; color: #d32f2f; font-size: 0.95rem; margin-bottom: 10px;">Date of Birth</label>
                    <div style="display: flex; gap: 10px; justify-content: center;">
                        <input type="text" name="month" style="width: 60px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; text-align: center; box-sizing: border-box;" placeholder="mm" maxlength="2" required>
                        <input type="text" name="day" style="width: 60px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; text-align: center; box-sizing: border-box;" placeholder="dd" maxlength="2" required>
                        <input type="text" name="year" style="width: 80px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; text-align: center; box-sizing: border-box;" placeholder="yyyy" maxlength="4" required>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: flex; align-items: center; gap: 10px; color: #d32f2f; font-size: 0.9rem;">
                        <input type="checkbox" style="width: 18px; height: 18px;">
                        <span>I'd like to receive exclusive offers and promotions via SMS</span>
                    </label>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: flex; align-items: flex-start; gap: 10px; color: #d32f2f; font-size: 0.9rem;">
                        <input type="checkbox" style="width: 18px; height: 18px; margin-top: 2px;" required>
                        <span>I agree with with LCC FARM EGGS <a href="#" style="color: #d32f2f; text-decoration: none;">Privacy Policy</a> and <a href="#" style="color: #d32f2f; text-decoration: none;">Terms of Use</a></span>
                    </label>
                </div>

                <div style="text-align: center; margin-bottom: 20px;">
                    <button type="submit" style="background-color: #d32f2f; color: white; padding: 12px 40px; border-radius: 25px; font-weight: bold; font-size: 1rem; border: none; cursor: pointer;">SIGN UP NOW</button>
                </div>
            </form>

            <p style="text-align: center; color: #666; font-size: 0.9rem; margin: 0;">
                Already have an account? <a href="{{ route('login') }}" style="color: #d32f2f; text-decoration: none;">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection
