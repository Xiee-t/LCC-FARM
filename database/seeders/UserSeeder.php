<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Buyer Demo',
                'email' => 'buyer@example.com',
                'role' => 'buyer',
            ],
            [
                'name' => 'Supplier Demo',
                'email' => 'supplier@example.com',
                'role' => 'supplier',
            ],
            [
                'name' => 'Distributor Demo',
                'email' => 'distributor@example.com',
                'role' => 'distributor',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => Hash::make('password123'),
                ]
            );
        }
    }
}
