<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing data for these tables
        Supplier::truncate();
        Product::truncate();
        Order::truncate();

        // Create 3 suppliers
        Supplier::create([
            'name' => 'LCC Farms',
            'products' => 'Eggs, Poultry',
            'rating' => 4.8,
            'status' => 'Active',
        ]);

        Supplier::create([
            'name' => 'Green Valley Farm',
            'products' => 'Eggs, Feed',
            'rating' => 4.7,
            'status' => 'Active',
        ]);

        Supplier::create([
            'name' => 'Sunny Ridge Poultry',
            'products' => 'Eggs, Chicks',
            'rating' => 4.5,
            'status' => 'Active',
        ]);

        // Create 5 products
        Product::create([
            'name' => 'Large Eggs',
            'stock' => 1000,
            'price' => 50.00,
            'description' => 'Premium large eggs from free-range hens',
        ]);

        Product::create([
            'name' => 'Medium Eggs',
            'stock' => 800,
            'price' => 45.00,
            'description' => 'Standard medium eggs',
        ]);

        Product::create([
            'name' => 'Jumbo Eggs',
            'stock' => 500,
            'price' => 55.00,
            'description' => 'Extra large jumbo eggs',
        ]);

        Product::create([
            'name' => 'Organic Eggs',
            'stock' => 300,
            'price' => 60.00,
            'description' => 'Certified organic eggs',
        ]);

        Product::create([
            'name' => 'Brown Eggs',
            'stock' => 600,
            'price' => 48.00,
            'description' => 'Healthy brown shell eggs',
        ]);

        // Create 10 orders with matching supplier/product names
        $supplierNames = ['LCC Farms', 'Green Valley Farm', 'Sunny Ridge Poultry'];
        $productNames = ['Large Eggs', 'Medium Eggs', 'Jumbo Eggs', 'Organic Eggs', 'Brown Eggs'];
        $statuses = ['Pending', 'Pending', 'Pending', 'Pending', 'In Transit', 'In Transit', 'In Transit', 'Delivered', 'Delivered', 'Accepted'];
        $prices = [50, 45, 55, 60, 48, 50, 55, 45, 60, 50];

        for ($i = 0; $i < 10; $i++) {
            Order::create([
                'order_id' => 'ORD-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'supplier' => $supplierNames[$i % 3],
                'product' => $productNames[$i % 5],
                'quantity' => rand(20, 100),
                'expected_delivery' => now()->addDays(rand(1, 14))->format('Y-m-d'),
'status' => $statuses[$i],
                'distributor_id' => null,  // Will be set when accepted
                'total_price' => rand(20, 100) * $prices[$i % 5],
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
