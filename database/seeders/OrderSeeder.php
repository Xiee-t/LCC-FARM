<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $distributorId = User::where('email', 'distributor@example.com')->value('id');

        $orders = [
            [
                'order_id' => 'ORD-1001',
                'supplier' => 'LCC Farms',
                'product' => 'Medium Eggs',
                'quantity' => 30,
                'expected_delivery' => now()->addDays(2)->toDateString(),
                'status' => 'Pending',
                'total_price' => 6300,
                'distributor_id' => null,
                'created_at' => now()->subDays(1),
            ],
            [
                'order_id' => 'ORD-1002',
                'supplier' => 'Green Valley Farm',
                'product' => 'Large Eggs',
                'quantity' => 18,
                'expected_delivery' => now()->addDay()->toDateString(),
                'status' => 'In Transit',
                'total_price' => 4320,
                'distributor_id' => $distributorId,
                'created_at' => now()->subDays(2),
            ],
            [
                'order_id' => 'ORD-1003',
                'supplier' => 'Sunny Ridge Poultry',
                'product' => 'Small Eggs',
                'quantity' => 25,
                'expected_delivery' => now()->subDay()->toDateString(),
                'status' => 'Delivered',
                'total_price' => 4500,
                'distributor_id' => $distributorId,
                'created_at' => now()->subDays(4),
            ],
            [
                'order_id' => 'ORD-1004',
                'supplier' => 'LCC Farms',
                'product' => 'Brown Eggs',
                'quantity' => 20,
                'expected_delivery' => now()->addDays(3)->toDateString(),
                'status' => 'Pending',
                'total_price' => 4600,
                'distributor_id' => null,
                'created_at' => now()->subHours(10),
            ],
            [
                'order_id' => 'ORD-1005',
                'supplier' => 'Green Valley Farm',
                'product' => 'Organic Eggs',
                'quantity' => 12,
                'expected_delivery' => now()->addDays(4)->toDateString(),
                'status' => 'Accepted',
                'total_price' => 3360,
                'distributor_id' => $distributorId,
                'created_at' => now()->subHours(6),
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
