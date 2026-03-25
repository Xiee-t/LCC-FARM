@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; background-color: #f8f9fa;">
    <!-- Navigation Bar -->
    <nav style="background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 15px 0; position: sticky; top: 0; z-index: 100;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
            <h1 style="color: #d32f2f; font-size: 1.5rem; font-weight: bold; margin: 0;">LCC FARM EGGS</h1>
            <div>
                <a href="{{ route('signup') }}" style="background-color: #d32f2f; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-size: 1rem;">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div style="background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%); color: white; padding: 60px 20px; text-align: center;">
        <h2 style="font-size: 2.5rem; font-weight: bold; margin: 0 0 15px 0;">Welcome to LCC Farm Eggs</h2>
        <p style="font-size: 1.2rem; margin: 0; opacity: 0.9;">Premium quality eggs delivered directly to you</p>
    </div>

    <!-- Main Content -->
    <div style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
        <!-- Egg Sizes -->
        <div style="margin-bottom: 50px;">
            <h3 style="color: #d32f2f; font-size: 1.8rem; font-weight: bold; margin-bottom: 30px; text-align: center;">Egg Sizes</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <!-- Size Card 1 -->
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
                    <div style="background-color: #fff2f2; padding: 20px; border-radius: 8px; margin-bottom: 15px; font-size: 3rem;">🥚</div>
                    <h4 style="color: #d32f2f; font-size: 1.2rem; font-weight: bold; margin: 0 0 10px 0;">Small</h4>
                    <p style="color: #666; margin: 0 0 15px 0;">Perfect for light meals</p>
                    <div style="margin-bottom: 10px;">
                        <p style="color: #d32f2f; font-weight: bold; font-size: 1rem; margin: 0;">Retail: ₱230/Tray</p>
                        <p style="color: #666; font-size: 0.9rem; margin: 0;">Wholesale (min 10): ₱225/Tray</p>
                    </div>
                </div>

                <!-- Size Card 2 -->
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
                    <div style="background-color: #fff2f2; padding: 20px; border-radius: 8px; margin-bottom: 15px; font-size: 3rem;">🥚</div>
                    <h4 style="color: #d32f2f; font-size: 1.2rem; font-weight: bold; margin: 0 0 10px 0;">Medium</h4>
                    <p style="color: #666; margin: 0 0 15px 0;">Most popular choice</p>
                    <div style="margin-bottom: 10px;">
                        <p style="color: #d32f2f; font-weight: bold; font-size: 1rem; margin: 0;">Retail: ₱240/Tray</p>
                        <p style="color: #666; font-size: 0.9rem; margin: 0;">Wholesale (min 10): ₱235/Tray</p>
                    </div>
                </div>

                <!-- Size Card 3 -->
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
                    <div style="background-color: #fff2f2; padding: 20px; border-radius: 8px; margin-bottom: 15px; font-size: 3rem;">🥚</div>
                    <h4 style="color: #d32f2f; font-size: 1.2rem; font-weight: bold; margin: 0 0 10px 0;">Large</h4>
                    <p style="color: #666; margin: 0 0 15px 0;">Extra value for families</p>
                    <div style="margin-bottom: 10px;">
                        <p style="color: #d32f2f; font-weight: bold; font-size: 1rem; margin: 0;">Retail: ₱250/Tray</p>
                        <p style="color: #666; font-size: 0.9rem; margin: 0;">Wholesale (min 10): ₱245/Tray</p>
                    </div>
                </div>

                <!-- Size Card 4 -->
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
                    <div style="background-color: #fff2f2; padding: 20px; border-radius: 8px; margin-bottom: 15px; font-size: 3rem;">🥚</div>
                    <h4 style="color: #d32f2f; font-size: 1.2rem; font-weight: bold; margin: 0 0 10px 0;">XL</h4>
                    <p style="color: #666; margin: 0 0 15px 0;">Extra large portions</p>
                    <div style="margin-bottom: 10px;">
                        <p style="color: #d32f2f; font-weight: bold; font-size: 1rem; margin: 0;">Retail: ₱260/Tray</p>
                        <p style="color: #666; font-size: 0.9rem; margin: 0;">Wholesale (min 10): ₱255/Tray</p>
                    </div>
                </div>

                <!-- Size Card 5 -->
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 20px; text-align: center;">
                    <div style="background-color: #fff2f2; padding: 20px; border-radius: 8px; margin-bottom: 15px; font-size: 3rem;">🥚</div>
                    <h4 style="color: #d32f2f; font-size: 1.2rem; font-weight: bold; margin: 0 0 10px 0;">Jumbo</h4>
                    <p style="color: #666; margin: 0 0 15px 0;">Maximum size & value</p>
                    <div style="margin-bottom: 10px;">
                        <p style="color: #d32f2f; font-weight: bold; font-size: 1rem; margin: 0;">Retail: ₱280/Tray</p>
                        <p style="color: #666; font-size: 0.9rem; margin: 0;">Wholesale (min 10): ₱270/Tray</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sample Inventory Display -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 40px;">
            <h3 style="color: #d32f2f; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">Current Inventory</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #d32f2f;">
                        <th style="text-align: left; padding: 12px; color: #d32f2f; font-weight: bold;">Egg Size</th>
                        <th style="text-align: left; padding: 12px; color: #d32f2f; font-weight: bold;">Available Quantity</th>
                        <th style="text-align: left; padding: 12px; color: #d32f2f; font-weight: bold;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;">Small</td>
                        <td style="padding: 12px;">120 Trays</td>
                        <td style="padding: 12px;"><span style="background-color: #4caf50; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem;">In Stock</span></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;">Medium</td>
                        <td style="padding: 12px;">140 Trays</td>
                        <td style="padding: 12px;"><span style="background-color: #4caf50; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem;">In Stock</span></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;">Large</td>
                        <td style="padding: 12px;">100 Trays</td>
                        <td style="padding: 12px;"><span style="background-color: #4caf50; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem;">In Stock</span></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 12px;">XL</td>
                        <td style="padding: 12px;">70 Trays</td>
                        <td style="padding: 12px;"><span style="background-color: #ff9800; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem;">Low Stock</span></td>
                    </tr>
                    <tr>
                        <td style="padding: 12px;">Jumbo</td>
                        <td style="padding: 12px;">45 Trays</td>
                        <td style="padding: 12px;"><span style="background-color: #ff9800; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.85rem;">Low Stock</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('place-order') }}" style="background-color: #d32f2f; color: white; padding: 15px 40px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 1.1rem; display: inline-block;">Place Order</a>
            <a href="{{ route('view-orders') }}" style="background-color: #666; color: white; padding: 15px 40px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 1.1rem; display: inline-block;">View Orders</a>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background-color: #333; color: white; text-align: center; padding: 30px 20px; margin-top: 60px;">
        <p style="margin: 0;">© 2026 LCC Farm Eggs. All rights reserved.</p>
        <p style="margin: 5px 0 0 0; font-size: 0.9rem;">Quality Eggs | Trusted Delivery | Best Prices</p>
    </footer>
</div>
@endsection
