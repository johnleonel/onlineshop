<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Seed some sample products
        Product::create([
            'name' => 'Wireless Headphones',
            'price' => 2999.99,
            'description' => 'High-quality wireless headphones with noise cancellation.',
            'image' => 'https://via.placeholder.com/300x200?text=Headphones'
        ]);

        Product::create([
            'name' => 'Smartphone Case',
            'price' => 499.99,
            'description' => 'Protective case for your smartphone.',
            'image' => 'https://via.placeholder.com/300x200?text=Phone+Case'
        ]);

        Product::create([
            'name' => 'Laptop Stand',
            'price' => 1499.99,
            'description' => 'Ergonomic laptop stand for better posture.',
            'image' => 'https://via.placeholder.com/300x200?text=Laptop+Stand'
        ]);

        Product::create([
            'name' => 'Bluetooth Speaker',
            'price' => 1999.99,
            'description' => 'Portable Bluetooth speaker with great sound.',
            'image' => 'https://via.placeholder.com/300x200?text=Speaker'
        ]);
    }
}
