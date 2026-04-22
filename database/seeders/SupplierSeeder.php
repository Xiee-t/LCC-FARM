<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'LCC Farms',
                'products' => 'Small Eggs, Medium Eggs, Large Eggs',
                'rating' => 4.9,
                'status' => 'Active',
            ],
            [
                'name' => 'Green Valley Farm',
                'products' => 'Medium Eggs, Brown Eggs',
                'rating' => 4.7,
                'status' => 'Active',
            ],
            [
                'name' => 'Sunny Ridge Poultry',
                'products' => 'Large Eggs, Organic Eggs',
                'rating' => 4.6,
                'status' => 'Active',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
