<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@techbuy.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Create test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Create categories with all required fields
        $categories = [
            [
                'name' => 'iPhones',
                'slug' => 'iphones',
                'description' => 'Latest iPhone models',
                'is_active' => true,
            ],
            [
                'name' => 'MacBooks',
                'slug' => 'macbooks',
                'description' => 'MacBook Pro and Air',
                'is_active' => true,
            ],
            [
                'name' => 'Android Phones',
                'slug' => 'android-phones',
                'description' => 'Android smartphones',
                'is_active' => true,
            ],
            [
                'name' => 'Laptops',
                'slug' => 'laptops',
                'description' => 'Windows and Linux laptops',
                'is_active' => true,
            ],
            [
                'name' => 'Tablets',
                'slug' => 'tablets',
                'description' => 'iPads and Android tablets',
                'is_active' => true,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Tech accessories',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products with ALL REQUIRED FIELDS
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'Latest iPhone with Pro features and advanced camera system',
                'short_description' => 'Latest iPhone with Pro features',
                'price' => 999.00,
                'sale_price' => 899.00,
                'sku' => 'IPH-15-PRO-001',
                'category_id' => 1,
                'stock_quantity' => 50,
                'manage_stock' => true,
                'in_stock' => true,
                'is_active' => true,
                'brand' => 'Apple',
                'model' => 'iPhone 15 Pro',
            ],
            [
                'name' => 'MacBook Pro M3',
                'slug' => 'macbook-pro-m3',
                'description' => 'Powerful MacBook Pro with M3 chip for professional workflows',
                'short_description' => 'Powerful MacBook Pro with M3 chip',
                'price' => 1999.00,
                'sku' => 'MBP-M3-14-001',
                'category_id' => 2,
                'stock_quantity' => 25,
                'manage_stock' => true,
                'in_stock' => true,
                'is_active' => true,
                'brand' => 'Apple',
                'model' => 'MacBook Pro M3',
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'slug' => 'samsung-galaxy-s24',
                'description' => 'Latest Samsung flagship phone with AI features',
                'short_description' => 'Latest Samsung flagship phone',
                'price' => 799.00,
                'sale_price' => 699.00,
                'sku' => 'SAM-S24-128-001',
                'category_id' => 3,
                'stock_quantity' => 30,
                'manage_stock' => true,
                'in_stock' => true,
                'is_active' => true,
                'brand' => 'Samsung',
                'model' => 'Galaxy S24',
            ],
            [
                'name' => 'Dell XPS 13',
                'slug' => 'dell-xps-13',
                'description' => 'Premium ultrabook laptop with excellent display and portability',
                'short_description' => 'Premium ultrabook laptop',
                'price' => 1299.00,
                'sku' => 'DEL-XPS13-I7-001',
                'category_id' => 4,
                'stock_quantity' => 20,
                'manage_stock' => true,
                'in_stock' => true,
                'is_active' => true,
                'brand' => 'Dell',
                'model' => 'XPS 13',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
