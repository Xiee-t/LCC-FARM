<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Small Eggs',
                'stock' => 180,
                'price' => 180.00,
                'description' => 'Budget-friendly trays for everyday retail demand.',
            ],
            [
                'name' => 'Medium Eggs',
                'stock' => 240,
                'price' => 210.00,
                'description' => 'Balanced stock and pricing for the most common orders.',
            ],
            [
                'name' => 'Large Eggs',
                'stock' => 120,
                'price' => 240.00,
                'description' => 'Higher-value trays ideal for premium buyers.',
            ],
            [
                'name' => 'Brown Eggs',
                'stock' => 90,
                'price' => 230.00,
                'description' => 'Brown shell eggs for customers who prefer specialty stock.',
            ],
            [
                'name' => 'Organic Eggs',
                'stock' => 60,
                'price' => 280.00,
                'description' => 'Organic trays for health-focused market segments.',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
