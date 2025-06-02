<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EshopSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Create regular user
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Create categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic devices and gadgets',
        ]);

        $computers = Category::create([
            'name' => 'Computers',
            'description' => 'Desktop and laptop computers',
            'parent_id' => $electronics->id,
        ]);

        $phones = Category::create([
            'name' => 'Phones',
            'description' => 'Mobile phones and smartphones',
            'parent_id' => $electronics->id,
        ]);

        $clothing = Category::create([
            'name' => 'Clothing',
            'description' => 'Apparel and fashion items',
        ]);

        $mens = Category::create([
            'name' => 'Men\'s Clothing',
            'description' => 'Clothing for men',
            'parent_id' => $clothing->id,
        ]);

        $womens = Category::create([
            'name' => 'Women\'s Clothing',
            'description' => 'Clothing for women',
            'parent_id' => $clothing->id,
        ]);

        // Create products
        Product::create([
            'name' => 'Laptop Dell XPS 13',
            'description' => 'Ultra-thin laptop with Intel Core i7 processor',
            'price' => 1299.99,
            'sku' => 'DELL-XPS-13',
            'stock' => 15,
            'category_id' => $computers->id,
        ]);

        Product::create([
            'name' => 'MacBook Pro 14"',
            'description' => 'Apple MacBook Pro with M1 Pro chip',
            'price' => 1999.99,
            'sku' => 'MACBOOK-PRO-14',
            'stock' => 10,
            'category_id' => $computers->id,
        ]);

        Product::create([
            'name' => 'iPhone 13 Pro',
            'description' => 'Latest iPhone with ProMotion display',
            'price' => 999.99,
            'sku' => 'IPHONE-13-PRO',
            'stock' => 25,
            'category_id' => $phones->id,
        ]);

        Product::create([
            'name' => 'Samsung Galaxy S22',
            'description' => 'Android flagship with amazing camera',
            'price' => 899.99,
            'sku' => 'SAMSUNG-S22',
            'stock' => 20,
            'category_id' => $phones->id,
        ]);

        Product::create([
            'name' => 'Men\'s T-Shirt',
            'description' => 'Comfortable cotton t-shirt',
            'price' => 19.99,
            'sku' => 'MENS-TSHIRT-01',
            'stock' => 50,
            'category_id' => $mens->id,
        ]);

        Product::create([
            'name' => 'Men\'s Jeans',
            'description' => 'Classic blue jeans',
            'price' => 49.99,
            'sku' => 'MENS-JEANS-01',
            'stock' => 30,
            'category_id' => $mens->id,
        ]);

        Product::create([
            'name' => 'Women\'s Dress',
            'description' => 'Elegant summer dress',
            'price' => 79.99,
            'sku' => 'WOMENS-DRESS-01',
            'stock' => 20,
            'category_id' => $womens->id,
        ]);

        Product::create([
            'name' => 'Women\'s Blouse',
            'description' => 'Professional blouse for office wear',
            'price' => 39.99,
            'sku' => 'WOMENS-BLOUSE-01',
            'stock' => 35,
            'category_id' => $womens->id,
        ]);
    }
}