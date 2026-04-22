@extends('layouts.app')

@section('content')
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600;700&family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap');
        
        .font-fraunces { font-family: 'Fraunces', serif; }
        .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<div class="font-jakarta" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #fdfbf7; padding: 20px;">
    
    <div style="width: 100%; max-width: 450px;">
        
        <div style="text-align: center; margin-bottom: 25px;">
            <a href="{{ route('login') }}" style="color: #b84934; text-decoration: none; font-size: 0.9rem; margin-right: 20px; border-bottom: 2px solid #b84934; padding-bottom: 3px; font-weight: 600;">Login</a>
            <a href="{{ route('signup') }}" style="color: #666; text-decoration: none; font-size: 0.9rem; font-weight: 600;">Sign Up</a>
        </div>

        <div style="text-align: center; margin-bottom: 25px;">
            <h1 class="font-fraunces" style="color: #822418; font-size: 2.2rem; margin: 0;">LCC Farm Eggs</h1>
        </div>

        <div style="background: linear-gradient(145deg, #b84934, #822418); color: #fff; border-radius: 20px; padding: 2.5rem 2rem; box-shadow: 0 15px 35px rgba(139, 38, 31, 0.15);">
            
            @if(session('success'))
                <div style="background-color: rgba(255,255,255,0.2); padding: 10px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.3); text-align:center;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background-color: rgba(255,0,0,0.2); padding: 10px; border-radius: 8px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.3);">
                    @foreach($errors->all() as $error)
                        <p style="margin: 0; font-size: 0.85rem;">• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <h2 class="font-fraunces" style="text-align: center; font-size: 1.8rem; margin-bottom: 25px; color: #fff; font-weight: 700;">Login</h2>
            
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                
                <div style="margin-bottom: 12px;">
                    <input type="text" name="login" style="width: 100%; padding: 12px; border: none; border-radius: 8px; box-sizing: border-box; background-color: #fff; color: #333;" placeholder="Enter phone or email" required>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <input type="password" name="password" style="width: 100%; padding: 12px; border: none; border-radius: 8px; box-sizing: border-box; background-color: #fff; color: #333;" placeholder="Password" required>
                </div>
                
                <div style="text-align: center; margin-bottom: 25px;">
                    <button type="submit" style="width: 100%; background-color: #fff; color: #822418; padding: 14px; border-radius: 25px; font-weight: 700; border: none; cursor: pointer; text-transform: uppercase; letter-spacing: 0.5px;">Login</button>
                </div>
            </form>

            <p style="text-align: center; font-size: 0.85rem; margin: 0; opacity: 0.9;">
                Don't have an account? <a href="{{ route('signup') }}" style="color: #fff; font-weight: 700; text-decoration: underline;">Sign Up</a>
            </p>
        </div>
    </div>
</div>
@endsection
