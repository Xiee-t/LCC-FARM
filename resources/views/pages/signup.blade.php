@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap');
    
    .font-fraunces { font-family: 'Fraunces', serif; }
    .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="font-jakarta" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #fdfbf7; padding: 20px;">
    
    <div style="width: 100%; max-width: 500px;">
        
        <div style="text-align: center; margin-bottom: 25px;">
            <a href="{{ route('login') }}" style="color: #666; text-decoration: none; font-size: 0.9rem; margin-right: 20px;">Login</a>
            <a href="{{ route('signup') }}" style="color: #b84934; text-decoration: none; font-size: 0.9rem; border-bottom: 2px solid #b84934; padding-bottom: 3px; font-weight: 600;">Sign Up</a>
        </div>

        <div style="text-align: center; margin-bottom: 25px;">
            <h1 class="font-fraunces" style="color: #822418; font-size: 2rem; margin: 0;">LCC Farm Eggs</h1>
        </div>

        <div style="background: linear-gradient(145deg, #b84934, #822418); color: #fff; border-radius: 20px; padding: 2rem; box-shadow: 0 15px 35px rgba(139, 38, 31, 0.15);">
            
            @if(session('success'))
                <div style="background-color: rgba(255,255,255,0.2); color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.3); font-size: 0.9rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background-color: rgba(255,0,0,0.2); color: #fff; padding: 10px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.3); font-size: 0.9rem;">
                    @foreach($errors->all() as $error)
                        <p style="margin: 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <h2 class="font-fraunces" style="text-align: center; font-size: 1.5rem; margin-bottom: 20px; color: #fff;">Sign Up</h2>
            
            <form method="POST" action="{{ route('signup.post') }}">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Select Your Role</label>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        @foreach(['buyer' => 'Buyer/User', 'distributor' => 'Distributor', 'supplier' => 'Supplier'] as $val => $label)
                        <label style="display: flex; align-items: center; gap: 10px; padding: 10px; border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; cursor: pointer; background: rgba(255,255,255,0.08);">
                            <input type="radio" name="role" value="{{ $val }}" style="cursor: pointer;" required>
                            <span style="font-size: 0.9rem;">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div style="margin-bottom: 12px;">
                    <input type="email" name="email" style="width: 100%; padding: 10px; border: none; border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;" placeholder="Email" required>
                </div>
                
                <div style="margin-bottom: 12px;">
                    <input type="password" name="password" style="width: 100%; padding: 10px; border: none; border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;" placeholder="Password" required>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <input type="text" name="phone" style="width: 100%; padding: 10px; border: none; border-radius: 6px; font-size: 0.9rem; box-sizing: border-box;" placeholder="Phone Number" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-size: 0.85rem; margin-bottom: 8px;">Date of Birth</label>
                    <div style="display: flex; gap: 8px; width: 100%;">
                        <input type="text" name="month" style="flex: 1; min-width: 0; padding: 10px; border: none; border-radius: 6px; text-align: center; box-sizing: border-box; font-size: 0.9rem;" placeholder="mm" maxlength="2" required>
                        <input type="text" name="day" style="flex: 1; min-width: 0; padding: 10px; border: none; border-radius: 6px; text-align: center; box-sizing: border-box; font-size: 0.9rem;" placeholder="dd" maxlength="2" required>
                        <input type="text" name="year" style="flex: 1; min-width: 0; padding: 10px; border: none; border-radius: 6px; text-align: center; box-sizing: border-box; font-size: 0.9rem;" placeholder="yyyy" maxlength="4" required>
                    </div>
                </div>

                <div style="margin-bottom: 15px; font-size: 0.8rem;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" style="width: 16px; height: 16px; cursor: pointer;">
                        <span>Receive exclusive offers via SMS</span>
                    </label>
                </div>

                <div style="margin-bottom: 20px; font-size: 0.8rem;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" style="width: 16px; height: 16px; cursor: pointer;" required>
                        <span>I agree to the <a href="#" style="color: #fff; text-decoration: underline;">Privacy Policy</a> and <a href="#" style="color: #fff; text-decoration: underline;">Terms of Use</a></span>
                    </label>
                </div>

                <div style="text-align: center;">
                    <button type="submit" style="background-color: #fff; color: #822418; padding: 12px 30px; border-radius: 20px; font-weight: 700; font-size: 0.95rem; border: none; cursor: pointer; width: 100%; text-transform: uppercase;">Sign Up Now</button>
                </div>
            </form>

            <p style="text-align: center; color: #fff; font-size: 0.85rem; margin-top: 15px; opacity: 0.9;">
                Already have an account? <a href="{{ route('login') }}" style="color: #fff; font-weight: 700; text-decoration: underline;">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection