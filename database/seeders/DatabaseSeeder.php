<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Delivery;
use App\Models\EggProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Delivery::truncate();
        OrderItem::truncate();
        Order::truncate();
        Business::truncate();
        EggProduct::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $customer = User::create([
            'name' => 'Buyer User',
            'email' => 'buyer@gmail.com',
            'phone' => '09170000001',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $supplierUser = User::create([
            'name' => 'Supplier User',
            'email' => 'supplier@gmail.com',
            'phone' => '09170000002',
            'password' => Hash::make('password123'),
            'role' => 'supplier',
        ]);

        $supplierUserTwo = User::create([
            'name' => 'Green Valley Owner',
            'email' => 'supplier2@gmail.com',
            'phone' => '09170000004',
            'password' => Hash::make('password123'),
            'role' => 'supplier',
        ]);

        $supplierUserThree = User::create([
            'name' => 'Sunny Ridge Owner',
            'email' => 'supplier3@gmail.com',
            'phone' => '09170000005',
            'password' => Hash::make('password123'),
            'role' => 'supplier',
        ]);

        $distributorUser = User::create([
            'name' => 'Distributor User',
            'email' => 'distributor@gmail.com',
            'phone' => '09170000003',
            'password' => Hash::make('password123'),
            'role' => 'distributor',
        ]);

        $supplierBusinesses = collect([
            Business::create([
                'user_id' => $supplierUser->id,
                'business_name' => 'LCC Farms',
                'address' => 'Barangay San Jose, Legazpi City',
                'contact_person' => $supplierUser->name,
            ]),
            Business::create([
                'user_id' => $supplierUserTwo->id,
                'business_name' => 'Green Valley Farm',
                'address' => 'Daraga, Albay',
                'contact_person' => $supplierUserTwo->name,
            ]),
            Business::create([
                'user_id' => $supplierUserThree->id,
                'business_name' => 'Sunny Ridge Poultry',
                'address' => 'Camalig, Albay',
                'contact_person' => $supplierUserThree->name,
            ]),
        ]);

        $distributorBusiness = Business::create([
            'user_id' => $distributorUser->id,
            'business_name' => 'LCC Distribution Hub',
            'address' => 'Main Logistics Center, Legazpi City',
            'contact_person' => $distributorUser->name,
        ]);

        $products = collect([
            EggProduct::create([
                'category' => 'Small',
                'price_per_unit' => 180.00,
                'stock_quantity' => 180,
                'low_stock_threshold' => 80,
            ]),
            EggProduct::create([
                'category' => 'Medium',
                'price_per_unit' => 210.00,
                'stock_quantity' => 120,
                'low_stock_threshold' => 100,
            ]),
            EggProduct::create([
                'category' => 'Large',
                'price_per_unit' => 240.00,
                'stock_quantity' => 90,
                'low_stock_threshold' => 80,
            ]),
            EggProduct::create([
                'category' => 'Tray',
                'price_per_unit' => 260.00,
                'stock_quantity' => 60,
                'low_stock_threshold' => 30,
            ]),
        ]);

        $orderStatuses = ['Pending', 'Pending', 'In Progress', 'Completed', 'Pending', 'Completed'];
        $deliveryStatuses = ['Preparing', 'On the Way', 'On the Way', 'Delivered', 'Preparing', 'Delivered'];

        for ($i = 0; $i < 6; $i++) {
            $product = $products[$i % $products->count()];
            $supplier = $supplierBusinesses[$i % $supplierBusinesses->count()];
            $quantity = 20 + ($i * 8);
            $totalAmount = ($product->price_per_unit * $quantity) + 50;

            $order = Order::create([
                'user_id' => $customer->id,
                'customer_type' => 'registered',
                'order_number' => 'ORD-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                'order_status' => $orderStatuses[$i],
                'supplier_id' => $supplier->id,
                'total_amount' => $totalAmount,
                'created_at' => now()->subDays(6 - $i),
                'updated_at' => now()->subDays(6 - $i),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $product->price_per_unit,
            ]);

            Delivery::create([
                'order_id' => $order->id,
                'distributor_id' => $i < 4 ? $distributorBusiness->id : null,
                'delivery_status' => $deliveryStatuses[$i],
                'delivery_address' => 'House ' . ($i + 1) . ', Legazpi City, 4500',
                'suggested_sequence' => $i + 1,
                'actual_delivery_time' => $deliveryStatuses[$i] === 'Delivered' ? now()->subDays(max(1, 3 - $i)) : null,
            ]);
        }
    }
}
