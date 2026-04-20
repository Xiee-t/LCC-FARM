@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    .landing-body { display: flex; flex-direction: column; min-height: 100vh; font-family: 'Plus Jakarta Sans', 'Jakarta Sans', sans-serif; color: #2f2f2f; }
    .landing-body h1, .landing-body h2, .landing-body h3, .landing-body h4, .landing-body h5 { font-family: 'Fraunces', serif; }
    .landing-main { flex: 1; }
    .button-pill { border-radius: 999px; }
</style>
<div class="landing-body" style="background-color: #f9f7f3;">
    <!-- Top Nav -->
    <header style="position: sticky; top: 0; z-index: 100; background: #ffffff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);">
        <div style="max-width: 1200px; margin: 0 auto; padding: 10px 20px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 38px; height: 38px; border-radius: 50%; background: #d32f2f; display: flex; align-items: center; justify-content: center; font-weight: 900; color: white;">LCC</div>
                <span style="color: #d32f2f; font-weight: 800; font-size: 1.25rem;">LCC Farm Eggs</span>
            </div>
            <nav style="display: flex; align-items: center; gap: 20px; font-weight: 600; color: #555;">
                <a href="{{ route('dashboard') }}" style="color: #333; text-decoration: none;">Dashboard</a>
                <a href="{{ route('place-order') }}" style="color: #333; text-decoration: none;">Place Order</a>
                <a href="{{ route('my-orders') }}" style="color: #333; text-decoration: none;">My Orders</a>
                <a href="{{ route('profile') }}" style="color: #333; text-decoration: none;">Profile</a>
            </nav>
            <a href="{{ route('logout') }}" style="padding: 11px 20px; border-radius: 999px; background: #d32f2f; color: white; text-decoration: none; font-weight: 700;">Login</a>
        </div>
    </header>

    <main class="landing-main">
    <section style="background: #f9f7f3; padding: 70px 0 90px 0;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <div style="background: linear-gradient(145deg, #b84934, #822418); color: #fff; border-radius: 22px; padding: 2.1rem; box-shadow: 0 16px 40px rgba(29, 33, 28, 0.11); overflow: hidden;">
                <div style="display: grid; grid-template-columns: 1fr; gap: 16px; text-align: center;">
                    <h1 style="margin: 0; font-size: 2.75rem; color: #fff; font-weight: 800;">Farm-fresh eggs delivered with care</h1>
                    <p style="margin: 0; color: rgba(255,255,255,0.90); font-size: 1.05rem; line-height: 1.5;">From daily kitchen staples to bulk supply orders, LCC Farm Eggs keeps your shelves stocked with reliable quality and transparent pricing.</p>
                    <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 12px; margin-top: 18px;">
                        <a href="{{ route('signup') }}" style="background: #882323; color: #fff; padding: 12px 30px; border-radius: 999px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 16px rgba(0,0,0,0.22);" class="button-pill">Get Started</a>
                        <a href="{{ route('login') }}" style="background: #fff; color: #822418; padding: 12px 30px; border-radius: 999px; font-weight: 700; text-decoration: none; border: 2px solid #fff;" class="button-pill">I already have an account</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Tiers -->
    <section style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <h2 style="margin: 0; font-size: 2rem; color: #882828; font-weight: 800;">Egg Sizes And Pricing</h2>
            <p style="margin: 8px 0 0 0; color: #565656; font-size: 1rem;">Transparent per-tray rates for both retail and wholesale buyers.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
            <div style="background: white; border-radius: 12px; border: 1px solid #ece8e5; box-shadow: 0 6px 16px rgba(0,0,0,0.08); padding: 24px; text-align: center;">
                <h3 style="margin: 0 0 10px 0; color: #c62828;">Small</h3>
                <p style="margin: 0 0 10px 0; color: #666;">Perfect for light meals</p>
                <p style="margin: 0; font-size: 1.05rem; color: #b71c1c;"><strong>Retail: ₱230</strong> /Tray</p>
                <p style="margin: 6px 0 0; color: #8f8f8f;">Wholesale (min 10): ₱225/Tray</p>
            </div>
            <div style="background: #fffdfc; border-radius: 12px; border: 1px solid #f9c0b6; box-shadow: 0 8px 20px rgba(211, 47, 47, 0.12); padding: 24px; text-align: center; position: relative;">
                <span style="position: absolute; top: 14px; right: 14px; background: #2e7d32; color: white; padding: 4px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 700;">Popular</span>
                <h3 style="margin: 0 0 10px 0; color: #c62828;">Medium</h3>
                <p style="margin: 0 0 10px 0; color: #666;">Most popular choice</p>
                <p style="margin: 0; font-size: 1.05rem; color: #b71c1c;"><strong>Retail: ₱240</strong> /Tray</p>
                <p style="margin: 6px 0 0; color: #8f8f8f;">Wholesale (min 10): ₱235/Tray</p>
            </div>
            <div style="background: white; border-radius: 12px; border: 1px solid #ece8e5; box-shadow: 0 6px 16px rgba(0,0,0,0.08); padding: 24px; text-align: center;">
                <h3 style="margin: 0 0 10px 0; color: #c62828;">Large</h3>
                <p style="margin: 0 0 10px 0; color: #666;">Extra value for families</p>
                <p style="margin: 0; font-size: 1.05rem; color: #b71c1c;"><strong>Retail: ₱250</strong> /Tray</p>
                <p style="margin: 6px 0 0; color: #8f8f8f;">Wholesale (min 10): ₱245/Tray</p>
            </div>
            <div style="background: white; border-radius: 12px; border: 1px solid #ece8e5; box-shadow: 0 6px 16px rgba(0,0,0,0.08); padding: 24px; text-align: center;">
                <h3 style="margin: 0 0 10px 0; color: #c62828;">XL</h3>
                <p style="margin: 0 0 10px 0; color: #666;">Extra large portions</p>
                <p style="margin: 0; font-size: 1.05rem; color: #b71c1c;"><strong>Retail: ₱260</strong> /Tray</p>
                <p style="margin: 6px 0 0; color: #8f8f8f;">Wholesale (min 10): ₱255/Tray</p>
            </div>
            <div style="background: white; border-radius: 12px; border: 1px solid #ece8e5; box-shadow: 0 6px 16px rgba(0,0,0,0.08); padding: 24px; text-align: center;">
                <h3 style="margin: 0 0 10px 0; color: #c62828;">Jumbo</h3>
                <p style="margin: 0 0 10px 0; color: #666;">Maximum size & value</p>
                <p style="margin: 0; font-size: 1.05rem; color: #b71c1c;"><strong>Retail: ₱280</strong> /Tray</p>
                <p style="margin: 6px 0 0; color: #8f8f8f;">Wholesale (min 10): ₱270/Tray</p>
            </div>
        </div>

        <div style="display: flex; justify-content: center; gap: 14px; margin-top: 28px;">
            <a href="{{ route('place-order') }}" style="background-color: #d32f2f; padding: 12px 38px; border-radius: 999px; color: white; text-decoration: none; font-weight: 700;" class="button-pill">Place Order</a>
            <a href="{{ route('view-orders') }}" style="background-color: #555; padding: 12px 38px; border-radius: 999px; color: white; text-decoration: none; font-weight: 700;" class="button-pill">View Orders</a>
        </div>
    </section>
    </main>

    @include('components.footer')
</div>
@endsection
